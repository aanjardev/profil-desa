@extends('layouts.user')
@section('content')

        <!-- Promo Block Section -->
        @include('user.components.index_events.promo-block')

        <!--========== PAGE CONTENT ==========-->
        <!-- Masonry -->
        @include('user.components.index_events.masonry')

        <!-- Masonry -->
        @include('user.components.index_events.features')

        <!-- Upcoming Event -->
        @include('user.components.index_events.upcoming-events')

        <!-- Speakers -->
        @include('user.components.index_events.speakers')

        <!-- Plan -->
        @include('user.components.index_events.plan')

        <!-- Promo Section -->
        @include('user.components.index_events.promo-section')

        <!-- Clients -->
        @include('user.components.index_events.clients')

        <!-- Google Map -->
        @include('user.components.index_events.google-map')

        <!--========== END PAGE CONTENT ==========-->
@endsection
