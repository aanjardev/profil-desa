@extends('layouts.app')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'Selamat datang di Panel Admin Profil Desa.')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Stat Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-1">Total Wisata</h3>
        <p class="text-3xl font-bold text-gray-900">0</p>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-1">Total UMKM</h3>
        <p class="text-3xl font-bold text-gray-900">0</p>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-1">Publikasi</h3>
        <p class="text-3xl font-bold text-gray-900">0</p>
    </div>
</div>
@endsection
