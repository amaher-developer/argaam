<?php

namespace App\Console\Commands;

use App\Modules\Access\Models\AdminLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteAdminLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteAdminLog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        AdminLog::whereDate('created_at', '<', Carbon::today()->subDays(3))->forceDelete();
    }
}
