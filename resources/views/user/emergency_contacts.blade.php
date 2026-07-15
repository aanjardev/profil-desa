@extends('layouts.user')
@section('content')
<!--========== PAGE CONTENT ==========-->
@include('user.components.emergency_contacts.page_header_emergency_contacts')

<div class="g-bg-color--sky-light">
    @include('user.components.emergency_contacts.contact_box_card')
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection