<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Sendchkmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user_name;
    public $verification_code;
    /**
     * Create a new message instance.
     */
    public function __construct($user_name, $verification_code)
    {
        $this->user_name = $user_name;
        $this->verification_code = $verification_code;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '驗證碼發送信件',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.mail_chkmsg',
            with: [
                'user_name' => $this->user_name,
                'verification_code' => $this->verification_code
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
