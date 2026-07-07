@extends('layouts.user')

@section('content')

{{-- Swipe Slider --}}
@include('user.components.home.swipe-slider')

<!--========== PAGE CONTENT ==========-->
{{-- Features --}}
@include('user.components.home.features')

{{-- Parallax --}}
@include('user.components.home.parallax')

{{-- Culture --}}
@include('user.components.home.culture')

{{-- Subscribe --}}
@include('user.components.home.subscribe')

{{-- Portfolio Filter --}}
@include('user.components.home.portfolio-filter')

{{-- Portfolio Gallery --}}
@include('user.components.home.portfolio-gallery')

{{-- Testimonial --}}
@include('user.components.home.testimonial')

{{-- Clients --}}
@include('user.components.home.clients')

{{-- News --}}
@include('user.components.home.news')

{{-- Counter --}}
@include('user.components.home.counter')

{{-- Feedback Form --}}
@include('user.components.home.feedback-form')

<!-- Google Map -->
<section class="s-google-map">
    <div id="js__google-container" class="s-google-container g-height-400--xs"></div>
</section>
<!-- End Google Map -->
<!--========== END PAGE CONTENT ==========-->

@endsection