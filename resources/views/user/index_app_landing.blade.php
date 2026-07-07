@extends('layouts.user')
@section('content')

        <!-- Promo Block -->
        @include('user.components.index_app_landing.promo-block')

        <!-- Mockup -->
        @include('user.components.index_app_landing.mockup')

        <!--========== PAGE CONTENT ==========-->

        <!-- Video -->
        @include('user.components.index_app_landing.video')

        <!-- Mockup -->
        @include('user.components.index_app_landing.mockup')
        
        <!-- Portofolio -->
        @include('user.components.index_app_landing.portofolio')

        <!-- Plan -->
        @include('user.components.index_app_landing.plan')

        <!-- Subcribe -->
        @include('user.components.index_app_landing.subcribe')

        <!-- Testimonials -->
        @include('user.components.index_app_landing.testimonials')

        <!-- Clients -->
        @include('user.components.index_app_landing.clients')

        <!-- Contact -->
        @include('user.components.index_app_landing.contact')

        
        <!--========== END PAGE CONTENT ==========-->

        {{-- <!--========== FOOTER ==========-->
        <footer class="g-bg-color--dark">

        <!-- Links -->
        @include('user.components.index_app_landing.links')
            
        <!-- Copyright -->
        @include('user.components.index_app_landing.copyright')

        </footer>
        <!--========== END FOOTER ==========--> --}}

 @endsection
