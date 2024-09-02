<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $nickname;
    public $birthday;
    public $height;
    public $weight;
    public $user_name;
    public $age2;
    public $pregnant_state;
    public $birth_plan;
    public $allergy_state;
    public $order;
    public $drug;
    public $married_state;
    public $disease;
    public $today;

    /**
     * Create a new message instance.
     */

    public function __construct(
        $nickname2,
        $birthday,
        $height,
        $weight,
        $age2,
        $pregnant_state,
        $birth_plan,
        $allergy_state,
        $order,
        $drug,
        $married_state,
        $disease,
        $user_name,
        $today
    ) {
        $this->nickname = $nickname2;
        $this->birthday = $birthday;
        $this->height = $height;
        $this->weight = $weight;
        $this->age2 = $age2;
        $this->pregnant_state = $pregnant_state;
        $this->birth_plan = $birth_plan;
        $this->allergy_state = $allergy_state;
        $this->order = $order;
        $this->drug = $drug;
        $this->married_state = $married_state;
        $this->disease = $disease;
        $this->user_name = $user_name;
        $this->today = $today;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // from: new Address('優德麗莎@example.com', '優德麗莎'),
            subject: '優德麗莎會員註冊成功',
        );
    }

    /**
     * Get the message content definition.
     */

    public function content(): Content
    {
        return new Content(
            view: 'mail.mail_register',
            with: [
                'nickname' => $this->nickname,
                'birthday' => $this->birthday,
                'height' => $this->height,
                'weight' => $this->weight,
                'user_name' => $this->user_name,
                'age2' => $this->age2,
                'pregnant_state' => $this->pregnant_state,
                'birth_plan' => $this->birth_plan,
                'allergy_state' => $this->allergy_state,
                'order' => $this->order,
                'drug' => $this->drug,
                'married_state' => $this->married_state,
                'disease' => $this->disease,
                'today' => $this->today
            ]
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
