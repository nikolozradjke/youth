<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{

    public static $REGISTRATION_SEND_CODE = 0;
    public static $PASSWORD_RESET = 1;
    public static $QUERY_MAIL = 2;
    public static $DEFAULT_MAIL = 'support@youthplatform.gov.ge';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mail_identifier', 'subject', 'text', 'sender'
    ];

    public function format($arr)
    {
        $s = $this->text;
        foreach ($arr as $key => $value) {
            $key = '{' . strtoupper($key) . '}';
            $s = str_replace($key, $value, $s);
        }
        return $s;
    }
}
