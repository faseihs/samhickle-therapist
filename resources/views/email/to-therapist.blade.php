<p>Dear {{$therapist->name}},</p>
<p></p>
<p>You have a booking on {{Carbon::parse($booking->date)->format('d-m-Y')}} at {{$booking->time}}</p>
<p></p>
<p>Please <a target="_blank" href="https://therapist.co.uk/therapist/therapist/bookings">login</a> in to confirm your booking</p>
<p></p>
<p>Your Therapist.co.uk Team</p>