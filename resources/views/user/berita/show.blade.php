@extends('layouts.user')

@section('title', $post->title . ' - Berita & Artikel')

@section('content')
<!--========== PROMO BLOCK ==========-->
<div class="g-bg-position--center js__parallax-window" style="background: url('{{ asset('23/img/1920x1080/09.jpg') }}') 50% 0 no-repeat fixed;">
    <div class="g-container--md g-text-center--xs g-padding-y-150--xs">
        <p class="text-uppercase g-font-size-14--xs g-font-weight--700 g-color--white-opacity g-letter-spacing--2 g-margin-b-25--xs">Berita Desa</p>
        <h1 class="g-font-size-40--xs g-font-size-50--sm g-font-size-60--md g-color--white g-letter-spacing--1">Detail Berita</h1>
    </div>
</div>
<!--========== END PROMO BLOCK ==========-->

<!--========== PAGE CONTENT ==========-->
<div class="container g-padding-y-80--xs g-padding-y-125--sm">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8 g-margin-b-30--xs g-margin-b-0--md">
            <article class="g-bg-color--white g-box-shadow__dark-lightest-v2 g-radius--4 g-padding-x-30--xs g-padding-y-40--xs">
                <!-- Meta -->
                <div class="g-margin-b-20--xs text-center">
                    <span class="g-font-size-13--xs g-color--primary g-margin-r-15--xs"><i class="ti-tag g-margin-r-5--xs"></i>{{ $post->category ?? 'Umum' }}</span>
                    <span class="g-font-size-13--xs g-color--text g-margin-r-15--xs"><i class="ti-time g-margin-r-5--xs"></i>{{ $post->created_at->translatedFormat('d F Y') }}</span>
                    <span class="g-font-size-13--xs g-color--text g-margin-r-15--xs"><i class="ti-user g-margin-r-5--xs"></i>Oleh: {{ $post->user->name ?? 'Admin' }}</span>
                    <span class="g-font-size-13--xs g-color--text"><i class="ti-eye g-margin-r-5--xs"></i>{{ $post->views }} kali dibaca</span>
                </div>

                <!-- Title -->
                <h1 class="g-font-size-28--xs g-font-size-36--sm g-font-weight--700 text-center g-margin-b-30--xs" style="line-height: 1.3;">
                    {{ $post->title }}
                </h1>

                <!-- Featured Image -->
                @if($post->image)
                    <div class="g-margin-b-40--xs text-center">
                        <img class="img-responsive g-radius--4" src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" style="width: 100%; max-height: 450px; object-fit: cover;">
                    </div>
                @else
                    <div class="g-margin-b-40--xs text-center">
                        <img class="img-responsive g-radius--4" src="{{ asset('images/default-image.png') }}" alt="{{ $post->title }}" style="width: 100%; max-height: 450px; object-fit: cover;">
                    </div>
                @endif

                <!-- Content -->
                <div class="g-font-size-16--xs g-color--dark" style="line-height: 1.8; text-align: justify;">
                    {!! $post->content !!}
                </div>

                <!-- Tags & Share -->
                <div class="g-margin-t-40--xs" style="border-top: 1px solid #eee; padding-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <div class="g-margin-b-10--xs">
                        @if($post->tags)
                            @foreach(explode(',', $post->tags) as $tag)
                                <span class="g-bg-color--primary-opacity-lightest g-color--primary g-padding-x-10--xs g-padding-y-5--xs g-radius--50 g-font-size-12--xs g-margin-r-5--xs">
                                    #{{ trim($tag) }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                    
                    <div class="g-margin-b-10--xs">
                        <span class="g-font-size-13--xs g-font-weight--700 g-margin-r-10--xs">Bagikan:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="g-color--text g-color--primary--hover g-font-size-18--xs g-margin-r-10--xs"><i class="ti-facebook"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" target="_blank" class="g-color--text g-color--primary--hover g-font-size-18--xs g-margin-r-10--xs"><i class="ti-twitter"></i></a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}" target="_blank" class="g-color--text g-color--primary--hover g-font-size-18--xs"><i class="ti-sharethis"></i></a>
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        @include('user.berita.sidebar')
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection
