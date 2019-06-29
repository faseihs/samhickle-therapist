<?php

namespace App\Mail;

use App\Model\Booking;
use App\Model\Therapist;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ToTherapist extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $therapist;
    public $booking;
    public function __construct(Therapist $therapist,Booking $booking)
    {
        //
        $this->therapist=$therapist;
        $this->booking=$booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.to-therapist')
            ->subject("Booking Request")
            ->with(['therapist'=>$this->therapist,'booking'=>$this->booking]);
    }
}
