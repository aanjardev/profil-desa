@extends('layouts.user')
@section('content')

        <!-- Promo Block -->
        @include('user.components.index_lawyer.promo-block')

        <!--========== PAGE CONTENT ==========-->
        <!-- About -->
        @include('user.components.index_lawyer.about')
        
        <!-- Service -->
        @include('user.components.index_lawyer.service')
        
        <!-- Parallax -->
        @include('user.components.index_lawyer.parallax')

        <!-- Tab -->
        @include('user.components.index_lawyer.tab')

        <!-- Counter -->
        @include('user.components.index_lawyer.counter')

        <!-- Testimonials -->
        @include('user.components.index_lawyer.testimonials')

        <!-- News -->
        @include('user.components.index_lawyer.news')
        
        <!-- Feedback Form -->
        @include('user.components.index_lawyer.feedback-form')

        <!--========== END PAGE CONTENT ==========-->
@endsection