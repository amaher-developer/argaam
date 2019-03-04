<?php

namespace App\Console\Commands;

use App\Modules\Exceptionhandler\Models\ApiLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteApiLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteApiLog';

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
        ApiLog::whereDate('created_at', '<', Carbon::today()->subDays(3))->forceDelete();
    }
}
