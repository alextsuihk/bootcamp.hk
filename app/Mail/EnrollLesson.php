<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Lesson;

class EnrollLesson extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $user;
    protected $lesson;
    protected $waitlisted;
    protected $sequence;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Lesson $lesson, $waitlisted, $sequence)
    {
        $this->user = $user;
        $this->lesson = $lesson;
        $this->waitlisted = $waitlisted;
        $this->sequence = $sequence;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $lesson_number = $this->lesson->course->number.'-'.sprintf('%02d', $this->lesson->sequence);
        $url = route('courses.show', 
            [$this->lesson->course->number, str_slug($this->lesson->course->title)]) . '/lessons';

        return $this->subject('Enrollment Confirmation')
            ->markdown('emails.enroll_lession', 
            ['user' => $this->user, 'lesson' => $this->lesson, 
            'sequence' => $this->sequence, 'waitlisted' => $this->waitlisted, 
             'number' => $lesson_number, 'url' => $url]
        );
    }
}
