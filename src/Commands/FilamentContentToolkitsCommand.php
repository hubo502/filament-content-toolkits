<?php

namespace Darko\FilamentContentToolkits\Commands;

use Illuminate\Console\Command;

class FilamentContentToolkitsCommand extends Command
{
    public $signature = 'filament-content-toolkits';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
