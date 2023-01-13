<?php

namespace App\Console\Commands;

use App\MailTemplate;
use Illuminate\Console\Command;
use App\Opportunity;
use App\OpportunityFilter;
use Illuminate\Support\Facades\Mail;

use Log;

class QueryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queries:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'After opportunities are finished, send queries to users who had these opportunities marked as "Going"';

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
        $now = \Carbon\Carbon::now()->format('Y-m-d H:m:s');
        $finishedOpportunities = OpportunityFilter::filterOpportunities([], null, 'desc', 0, null, true)
            ->where('opportunities.end_date', '<', $now)
            ->where('query_sent', 0)
            ->get();

        foreach ($finishedOpportunities as $opportunity) {
            // TODO get users and a query for each opportunity and send email with set ids of the opportunity and the user

            $users = $opportunity->goingUsers;

            $queryId = $opportunity->query_id;

            if ($queryId) {
                foreach ($users as $user) {
                    try {
                        $rid = $user->getRandomId($opportunity->id);
                        $email = $user->email;
                        $mailTemplate = MailTemplate::where('mail_identifier', MailTemplate::$QUERY_MAIL)->first();
                        $link = url('/query/' . $opportunity->id . '/' . $user->id . '/?token=' . $rid);

                        if ($mailTemplate) {
                            $subject = $mailTemplate->subject;
                            $mail = $mailTemplate->format([
                                'LINK' => $link,
                                'USER_FIRST_NAME' =>$user->first_name,
                                'OPPORTUNITY_NAME' =>$opportunity->name,
                            ]);
                            $sender = $mailTemplate->sender;
                        } else {
                            $subject = "Query";
                            $msg = "%s\n\n" .
                                "როგორც გავიგეთ, ცოტა ხნის წინ დაინტერესდი შემდეგი შესაძლებლობით:\n%s\n\n" .
                                "შეგიძლია გვითხრა დარეგისტრირდი/დაესწარი თუ არა:\n\n%s";

                            $mail = sprintf($msg, $user->first_name, $opportunity->name, $link);
                            $sender = MailTemplate::$DEFAULT_MAIL;
                        }
                        Log::info($mail);
                        Mail::send('templates.email', ['text' => $mail], function ($message) use ($email, $subject, $sender) {
                            $message->to($email)
                                ->from($sender)
                                ->subject($subject);
                        });
                    } catch (\Exception $e) {
                        Log::error($e);
                        continue;
                    }
                }
                $opportunity->query_sent = 1;
                $opportunity->update();
            }
        }
    }
}
