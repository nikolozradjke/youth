<?php

namespace App\Console\Commands;

use App\OpportunityFilter;
use App\Subscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendNewsletterMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter';

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
        $mail_oports = OpportunityFilter::filterOpportunities(['types' => []], 'schedule_date', 'desc', 0, 5);
        $subsribers = Subscriber::select('email', 'token')->latest()->get();
        foreach($subsribers as $subscriber){
            Mail::send('email.subscribe', ['oportunities' => $mail_oports , 'token' => $subscriber->token], function ($message) use ($subscriber) {
                $message->to($subscriber->email)
                    ->from('support@youthplatform.gov.ge')
                    ->subject('Newslatter');
            });
        }
    }
}
