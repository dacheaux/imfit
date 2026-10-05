@extends('layouts.main')
@section('styles')
    <!-- Sweetalert -->
    <link rel="stylesheet" href="{{ asset('assets-admin/css/sweetalert.css') }}">
@endsection
@section('content')
    <!-- breadcrumb section start -->
    @include('partials.breadcrumb', ['pageTitle' => '404 Greška'])
    <!-- gallery section start -->
    <div class="ff_gallery_wrapper top_padder80 bottom_padder50">
        <div class="container">

            <h1>Greška 404 - Tražena strana nije pronađena.</h1>

        </div>
    </div>

@endsection

