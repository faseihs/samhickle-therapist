@if($type=="self")



<p>Dear {{$patient->name}},</p>
<p>Thank you for using Therapist.co.uk. Your appointment request has been sent to the therapist.</p>
<p>To manage your request go to <a href="https://therapist.co.uk/user/bookings">Dashboard</a></p>
<p></p>
<p>Be Well,</p>
<p>Your Therapist.co.uk Team</p>

@endif

@if($type!="self")

    <p>Dear {{$patient->name}},</p>
    <p></p>
    <p>Your booking on {{Carbon::parse($booking->date)->format('d-m-Y')}} at {{$booking->time}} has been {{$booking->Status}}</p>
    <p>To manage your request go to <a href="https://therapist.co.uk/user/bookings">Dashboard</a></p>
    <p></p>
    <p>Thank you for booking with therapist.co.uk</p>
    <p></p>
    <p>Your Therapist.co.uk Team</p>

@endif