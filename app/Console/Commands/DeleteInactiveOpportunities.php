<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Opportunity;

class DeleteInactiveOpportunities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'opportunities:delete_inactives';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'While creating opportunity user can click \'preview\' button after which dummy inactive opportunity is created, that should be deleted';

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
        Opportunity::where('inactive', 1)->delete();
    }
}
