@extends('layouts.user')
@section('content')
        <!--========== PAGE CONTENT ==========-->
        <!-- Promo Block Section -->
        @include('user.components.faq.page_header_faq')

        <!-- FA questions Text -->
        @include('user.components.faq.faq_lists')
        <!--========== END PAGE CONTENT ==========-->
@endsection