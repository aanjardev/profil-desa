@extends('layouts.user')
@section('content')
<!--========== PAGE CONTENT ==========-->
@include('user.components.emergency_contacts.page_header_emergency_contacts')

@include('user.components.emergency_contacts.contact_box_card')
<!--========== END PAGE CONTENT ==========-->
@endsection