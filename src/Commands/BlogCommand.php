<?php

namespace DrewRoberts\Blog\Commands;

use Illuminate\Console\Command;

class BlogCommand extends Command
{
    public $signature = 'blog';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
