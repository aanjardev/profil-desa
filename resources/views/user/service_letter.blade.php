@extends('layouts.user')
@section('content')
<!--========== PAGE CONTENT ==========-->
@include('user.components.services_letter.page_header_services_letter')
<div class="g-bg-color--sky-light">
    @include('user.components.services_letter.services_letter_list')        
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection