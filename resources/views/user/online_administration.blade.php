@extends('layouts.user')
@section('content')
<!--========== PAGE CONTENT ==========-->
    @include('user.components.online_administration.page_header_online_administration')

    @include('user.components.online_administration.online_administration_list')
<!--========== END PAGE CONTENT ==========-->
@endsection