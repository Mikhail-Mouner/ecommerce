<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteReadNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'read-notifications:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove All Read Notification From DataBase Older Than 5 Days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('notifications')
            ->whereNotNull('read_at')
            ->whereDate( 'read_at','<=',now()->subDays(5)->toDateTimeString() )
            ->delete();
        $this->info("All read notifications has removed!");
        
        return true;
    }
}
