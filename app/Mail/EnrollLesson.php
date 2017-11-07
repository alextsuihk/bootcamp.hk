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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Lesson $lesson)
    {
        $this->user = $user;
        $this->lesson = $lesson;
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
             'number' => $lesson_number, 'url' => $url]
        );
    }
}
