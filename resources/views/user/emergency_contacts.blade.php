@extends('layouts.user')
@section('content')
<!--========== PAGE CONTENT ==========-->
<div class="g-bg-position--center" style="background-color:#7a1d26cf; padding-top: 140px; padding-bottom: 20px;">
    <div class="container">
        <div class="g-text-center--xs">
            <div class="g-margin-t-40--xs g-margin-b-60--xs g-margin-b-80--sm s-header__emergency-contact">
                <h1 class="g-font-size-32--xs g-font-size-50--sm g-font-size-60--md g-margin-b-30--xs">Kontak Darurat</h1>
                <p class="text-uppercase g-font-size-20--md g-font-weight--300">Daftar kontak penting yang siap membantu masyarakat Desa kapan pun dibutuhkan.</p>
            </div>                
        </div>
    </div>
    @include('user.components.emergency_contacts.contact_box_card')
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection