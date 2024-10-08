<?php

namespace Darko\FilamentContentToolkits\Pages\Traits\NestedCreateRelatedRecord;

use Filament\Facades\Filament;
use Filament\Resources\Concerns\HasActiveLocaleSwitcher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

trait Translatable
{
    use HasActiveLocaleSwitcher;

    protected $child_record = null;

    protected ?string $oldActiveLocale = null;

    public function mountTranslatable(): void
    {
        $this->activeLocale = $this->getChildResource()::getDefaultTranslatableLocale();
    }

    public function getTranslatableLocales(): array
    {
        return $this->getChildResource()::getTranslatableLocales();
    }

    public function updatingActiveLocale(): void
    {
        $this->oldActiveLocale = $this->activeLocale;
    }

    public function updatedActiveLocale(string $newActiveLocale): void
    {
        if (blank($this->oldActiveLocale)) {
            return;
        }

        $this->resetValidation();

        $translatableAttributes = $this->getChildResource()::getTranslatableAttributes();

        $this->otherLocaleData[$this->oldActiveLocale] = Arr::only($this->data, $translatableAttributes);

        $this->data = [
            ...Arr::except($this->data, $translatableAttributes),
            ...$this->otherLocaleData[$this->activeLocale] ?? [],
        ];

        unset($this->otherLocaleData[$this->activeLocale]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getUrl(['record' => $this->getOwnerRecord()]);
    }

    #[Locked]
    public $otherLocaleData = [];

    protected function handleRecordCreationSaveRelation(Model $record): Model
    {
        if ($owner = $this->getOwnerRecord()) {
            $record = $this->associateRecordWithParent($record, $owner);
        }

        if (
            $this->getNestedResource($record)::isScopedToTenant() &&
            ($tenant = Filament::getTenant())
        ) {
            return $this->associateRecordWithTenant($record, $tenant);
        }

        $record->save();

        return $record;
    }

    protected function getChildResource()
    {
        return $this->getNestedResource($this->getChildRecord());
    }

    protected function getChildRecord()
    {
        return $this->child_record ?: $this->child_record = new ($this->getRelation()->getRelated());
    }

    protected function handleRecordCreation(array $data): Model
    {
        $record = $this->getChildRecord();
        $resource = $this->getChildResource();

        $translatableAttributes = $resource::getTranslatableAttributes();

        $record->fill(Arr::except($data, $translatableAttributes));

        foreach (Arr::only($data, $translatableAttributes) as $key => $value) {
            $record->setTranslation($key, $this->activeLocale, $value);
        }

        $originalData = $this->data;

        foreach ($this->otherLocaleData as $locale => $localeData) {
            $this->data = [
                ...$this->data,
                ...$localeData,
            ];

            try {
                $this->form->validate();
            } catch (ValidationException $exception) {
                continue;
            }

            $localeData = $this->mutateFormDataBeforeCreate($localeData);

            foreach (Arr::only($localeData, $translatableAttributes) as $key => $value) {
                $record->setTranslation($key, $locale, $value);
            }
        }

        $this->data = $originalData;

        return $this->handleRecordCreationSaveRelation($record);
    }
}
