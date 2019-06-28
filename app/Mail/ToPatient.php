<?php

namespace App\Mail;

use App\Model\Booking;
use App\Model\Therapist;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ToPatient extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $patient;
    public $type;
    public $booking;
    public $status;
    public function __construct($patient,$type,Booking $booking=null)
    {
        //
        $this->type=$type;
        $this->booking=$booking;
        $this->patient=$patient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.to-patient')
            ->with(['patient',$this->patient,'type'=>$this->type,'booking'=>$this->booking]);
    }
}
