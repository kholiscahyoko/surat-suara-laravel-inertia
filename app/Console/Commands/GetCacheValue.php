<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GetCacheValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:get {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the value of a cache item by its key';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $key = $this->argument('key');
        $value = Cache::get($key);

        if ($value !== null) {
            $this->info("Value for key '{$key}': {$value}");
        } else {
            $this->error("Cache item with key '{$key}' not found");
        }
    }
}
