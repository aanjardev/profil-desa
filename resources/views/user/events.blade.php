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
@endsection