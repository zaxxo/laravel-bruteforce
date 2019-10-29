<?php

namespace Zaxxo\LaravelBruteforce;

use Illuminate\Console\Command;

/**
 * Command for cleanup bruteforce attempts.
 *
 * @package Zaxxo\LaravelBruteforce
 * @internal
 */
class CleanupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bruteforce:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup bruteforce attempts.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $offset = BruteforceAttempt::getOffset();

        $deleted = BruteforceAttempt::where('attempted', '<', $offset)->delete();

        $this->info("Deleted {$deleted} bruteforce attempt(s)");
    }
}
