<?php

namespace Darko\FilamentContentToolkits\Model\Concerns;

use Artesaos\SEOTools\Facades\SEOMeta;
use Darko\FilamentContentToolkits\Facades\Site;

trait HasSeo
{
    public function setSeo(): void
    {
        SEOMeta::setTitle($this->resolveSeoTitle());
        SEOMeta::setDescription($this->resolveSeoDescription());

        if (isset($this->url)) {
            SEOMeta::setCanonical(url($this->url));
        }
    }

    protected function resolveSeoTitle()
    {

        $titleColumn = $this?->titleColumn ?? 'title';

        $title = ! empty($this->seo_title) ? $this->seo_title : $this->$titleColumn;

        $brand = Site::abbv();

        if (Site::seoUseBrand() && strlen($title) < Site::seoTitleMaxLength()) {
            $title = "{$title} | {$brand}";
            $title .= $this->resolveSeoTitleSuffix($title);
        }

        return $title;
    }

    protected function resolveSeoTitleSuffix(string $title, string $seperator = ' - '): string
    {
        $suffixCandidates = Site::seoTitleSuffixes();
        $remainLength = Site::seoTitleMaxLength() - strlen($title . $seperator);

        if ($remainLength) {
            $suffix = collect($suffixCandidates)->last(function ($suffix) use ($remainLength) {
                return strlen($suffix) <= $remainLength;
            });

            return $suffix ? $seperator . $suffix : '';
        }

        return $title;
    }

    protected function resolveSeoDescription()
    {

        if (strlen($this->seo_desc)) {
            return $this->seo_desc;
        } else {
            $descriptionColumn = $this?->descriptionColumn ?? 'description';
            $description = $this?->$descriptionColumn;

            if ($description && strlen($description) != 0) {
                return $description;
            } else {
                return Site::intro();
            }
        }
    }

    protected static function booted()
    {
        parent::booted();
        static::retrieved(fn ($model) => $model->setSeo());
    }
}
