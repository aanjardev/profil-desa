@extends('layouts.user')
@section('content')

{{-- Promo Block --}}
@include('user.components.about.promo-block')

<!--========== PAGE CONTENT ==========-->
{{-- About Company Section --}}
@include('user.components.about.about')

{{-- Process Section --}}
@include('user.components.about.process')

{{-- News Section --}}
@include('user.components.home.news')

{{-- Subscribe Section --}}
@include('user.components.about.subscribe')
<!--========== END PAGE CONTENT ==========-->

@endsection