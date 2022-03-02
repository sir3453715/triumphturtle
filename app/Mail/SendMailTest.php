<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendMailTest extends Mailable
{
    use Queueable, SerializesModels;

    protected $for_title;
    protected $is_admin;
    protected $template;
    protected $msg;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = array())
    {
        //
        $this->subject = $data['subject'];
        $this->for_title = $data['for_title'];
        $this->is_admin = $data['is_admin'];
        $this->template = $data['template'];
        $this->msg = $data['msg'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.'.$this->template)
            ->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'))
            ->subject($this->subject)
            ->with([
                'for_title'=>$this->for_title,
                'is_admin'=>$this->is_admin,
                'msg'=>$this->msg,
            ]);
    }
}
