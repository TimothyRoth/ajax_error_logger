<?php

namespace app\Settings\Ajax\SendMail;

use app\App;
use app\Database\Tables\LogTable;
use app\Services\Cron\Mail\MailService;

class SendMail
{
    /**
     *
     * Class SendMail
     *
     * Implementing Ajax method for sending e-mails.
     *
     **/
    public function __construct()
    {
        App::Ajax()->register(
            [
                'sendMail' => [$this, 'sendMail']
            ]
        );
    }

    /**
     * @throws \JsonException
     */
    public function sendMail(): void
    {
        $send_status = App::make(MailService::class)->sendMail();

        /*
         * Setting the log status of the send logs to 'sent', if the e-mail was sent successfully.
         * */

        if ($send_status) {
            App::make(LogTable::class)->setLogStatusToSent();
        }

        /*
        * Checking if the sendMail method returned true or false.
        * Respond with either a success message or an error message.
        * */
        $response_message = $send_status ? 'Die E-Mail wurde erfolgreich versendet.' : 'Derzeit befinden sich keine offenen Logs in der Datenbank.';

        App::Ajax()->respond(['message' => $response_message]);
    }


}