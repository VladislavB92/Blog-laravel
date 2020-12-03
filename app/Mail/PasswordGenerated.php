<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordGenerated extends Mailable
{
    use Queueable, SerializesModels;

    public $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function build()
    {
        return $this->from('admin@articles.lv')
            ->text('emails.password');
    }
}
