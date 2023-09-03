<?php

namespace App\Mail;

use App\Events\Potentials\PotentialWasRegistered;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PotentialAppliedEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance. $user refers to the potential.
     */
    public function __construct(
        private User $user,
        private UserProfile $profile,
        private PotentialWasRegistered $event
    ) {}
    

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nieuwe aanmelding',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.membership.application',
            with: [
                'fullname' => $this->user->present()->fullName,
                'gender' => $this->profile->present()->genderLocalized,
                'birthdate' => $this->profile->present()->birthdayWithYear,
                'user' => $this->user,
                'profile' => $this->profile,
                'school' => $this->event->school,
                'personal_message' => $this->event->message,
                'startYear' => $this->event->startYear,
                'parentsEmail' => $this->event->parentsEmail
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
