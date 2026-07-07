@extends('layouts.user')
@section('content')
        <!-- Promo Block Section -->
        @include('user.components.faq.promo-block')

        <!--========== PAGE CONTENT ==========-->
        <!-- FA questions Text -->
        @include('user.components.faq.fa-questions-text')

        <!-- Accordion -->
        @include('user.components.faq.accordion')
        
        <!-- Subcribe -->
        @include('user.components.faq.subcribe')
        <!--========== END PAGE CONTENT ==========-->
@endsection