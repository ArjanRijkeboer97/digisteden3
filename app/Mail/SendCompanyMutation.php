<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCompanyMutation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $company_shadow;
    public $company_old;
    public $message_top;
    public $message_bottom;
    public $subject;
    public $siteurl;
    public $slug;

    /**
     * Create a new bericht instance.
     *
     * @return void
     */
    public function __construct($company_shadow, $company_old, $message_top, $message_bottom, $subject, $slug, $siteurl)
    {
        $this->company_shadow = $company_shadow;
        $this->company_old = $company_old;

        $this->subject = $subject;
        $this->message_top = $message_top;
        $this->message_bottom = $message_bottom;
        $this->slug = $slug;
        $this->siteurl = $siteurl;
    }

    /**
     * Build the bericht.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('redactie@' . config('siteUrl'))
            ->view('mails.mutationconfirm');
    }
}
