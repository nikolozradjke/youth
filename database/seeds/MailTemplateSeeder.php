<?php

use App\MailTemplate;
use Illuminate\Database\Seeder;

class MailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailTemplate::Create([
            'mail_identifier' => MailTemplate::$REGISTRATION_SEND_CODE,
            'subject' => "Registration Completed",
            'text' => '<p>მადლობა ახალგაზრდობის პლათფორმაზე დარეგისტრირებისთვის</p>' .
                '<p>გთხოვთ შეიყვანოთ ეს კოდი რეგისტრაციის გვერდზე:</p>' .
                '<p>{CODE}</p>' .
                '<p>გთხოვთ, არ გაანდოთ ეს კოდი მე-3 პირს.</p>' .
                '<p>&nbsp;</p>' .
                '<p>იმ შემთხვევაში, თუ ვერ ახერხებთ რეგისტრაციის დასრულებას. გთხოვთ გაიმეოროთ პროცესი ან მოგვმართოთ ამავე ელ-ფოსტაზე.</p>',
            'sender' => MailTemplate::$DEFAULT_MAIL,
        ]);
        MailTemplate::Create([
            'mail_identifier' => MailTemplate::$PASSWORD_RESET,
            'subject' => "Password Reset",
            'text' => '<p>როგორც ჩანს, პაროლის აღდგენა მოითხოვე,</p>' .
                '<p>&nbsp;</p>' .
                '<p>ამისთვის მხოლოდ ამ ბმულზე გადასვლა და ინსტრუქციების მიყოლაა საჭირო:</p>' .
                '<p>{LINK}</p>',
            'sender' => MailTemplate::$DEFAULT_MAIL,
        ]);
        MailTemplate::Create([
            'mail_identifier' => MailTemplate::$QUERY_MAIL,
            'subject' => "Query",
            'text' => '<p>{USER_FIRST_NAME}</p>' .
                '<p>&nbsp;</p>' .
                '<p>როგორც გავიგეთ, ცოტა ხნის წინ დაინტერესდი შემდეგი შესაძლებლობით:</p>' .
                '<p>{OPPORTUNITY_NAME}</p>' .
                '<p>&nbsp;</p>' .
                '<p>შეგიძლია გვითხრა დარეგისტრირდი/დაესწარი თუ არა:</p>' .
                '<p>{LINK}</p>',
            'sender' => MailTemplate::$DEFAULT_MAIL,
        ]);
    }
}
