@extends('layouts.user')
@section('content')
    
@include('user.components.team.promo-block')

<!--========== PAGE CONTENT ==========-->

{{-- Speakers Section --}}
@include('user.components.team.speakers')

{{-- Team Section --}}
@include('user.components.team.team')

{{-- Feedback Form Section --}}
@include('user.components.team.feedback-form')

<!--========== END PAGE CONTENT ==========-->

@endsection