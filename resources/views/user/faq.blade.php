@extends('layouts.user')
@section('content')
        <!--========== PAGE CONTENT ==========-->
        <!-- Promo Block Section -->
        @include('user.components.faq.promo-block')

        <!-- FA questions Text -->
        @include('user.components.faq.fa-questions-text')
        <!--========== END PAGE CONTENT ==========-->
@endsection