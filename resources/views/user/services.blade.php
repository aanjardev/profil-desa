@extends('layouts.user')
@section('content')

        <!-- Promo Block -->
        @include('user.components.services.promo-block')
        

        <!--========== PAGE CONTENT ==========-->
        <!-- Mockup -->
        @include('user.components.services.mockup')

        <!-- Portofolio -->
        @include('user.components.services.portofolio')
        
        <!-- Counter -->
        @include('user.components.services.counter')
        
        <!-- Plan -->
        @include('user.components.services.plan')
        
        <!-- Testimonials -->
        @include('user.components.services.testimonials')
        
        <!-- Clients -->
        @include('user.components.services.clients')

        <!--========== END PAGE CONTENT ==========-->
@endsection