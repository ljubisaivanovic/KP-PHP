<?php

namespace App\Core\Utilities;

use App\Core\Email;

class EmailHelpers
{
    /**
     * @param $email
     * @return bool
     * @echo bool
     */
    public static function sendWelcomeEmail($email)
    {
        $mailer = new Email();

        return $mailer->from('adm@kupujemprodajem.com')
            ->to($email)
            ->subject('Welcome!')
            ->message('Welcome to KP. You need to confirm your email')
            ->send();
    }
}