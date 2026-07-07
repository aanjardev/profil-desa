@extends('layouts.user')
@section('content')

        <!-- Promo Block Section -->
        @include('user.components.index_portofolio.promo-block')

        <!--========== PAGE CONTENT ==========-->
        <!-- Portofolio Filter -->
        @include('user.components.index_portofolio.portofolio-filter')

        <!-- Portofolio Gallery -->
        @include('user.components.index_portofolio.portofolio-gallery')

        <!-- Clients -->
        @include('user.components.index_portofolio.clients')

        <!--========== END PAGE CONTENT ==========-->
@endsection