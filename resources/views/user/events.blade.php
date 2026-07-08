@extends('layouts.user')
@section('content')

<!-- Promo Block Section -->
@include('user.components.events.promo-block')

<!--========== PAGE CONTENT ==========-->
<!-- features -->
@include('user.components.events.features')

<!-- UPCOMING EVENT -->
@include('user.components.events.upcoming-event')
       
<!-- SPEAKERS -->
@include('user.components.events.speakers')

<!-- CLIENTS -->
@include('user.components.events.clients')

<!--========== END PAGE CONTENT ==========-->

<!-- Google Map -->
<section class="s-google-map" style="line-height: 0;">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126495.02968887163!2d112.4478961177661!3d-7.793035139561266!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e787e9ca033bae9%3A0x25ba2f886ca3318d!2sTulungrejo%2C%20Kec.%20Bumiaji%2C%20Kota%20Batu%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1783485930762!5m2!1sid!2sid"
    width="100%"
    height="400"
    style="border:0; vertical-align: middle;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</section>
<!-- End Google Map -->

@endsection