<?php

namespace App\Mail;

use App\Events\Members\MemberFileWasCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemberFileEmail extends Mailable
{
    use Queueable, SerializesModels;

    private MemberFileWasCreated $event;
    private string $month;
    private int $year;

    /**
     * Create a new message instance.
     */
    public function __construct(MemberFileWasCreated $event) 
    {
        $this->event = $event;
        
        $created_at = $event->getAt();
        $this->month = $created_at->getTranslatedMonthName();
        $this->year = $created_at->year;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Ledenbestand " . $this->month . " " . $this->year,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.memberfile',
            with: [
                'month' => $this->month,
                'year' => $this->year
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
        return [
            Attachment::fromPath($this->event->getFilePath())
                ->withMime('application/vnd.ms-excel')
        ];
    }
}
