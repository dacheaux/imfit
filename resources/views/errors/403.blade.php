@extends('layouts.main')
@section('styles')
    <!-- Sweetalert -->
    <link rel="stylesheet" href="{{ asset('assets-admin/css/sweetalert.css') }}">
@endsection
@section('content')
    <!-- breadcrumb section start -->
    @include('partials.breadcrumb', ['pageTitle' => '403 Greška'])
    <!-- gallery section start -->
    <div class="ff_gallery_wrapper top_padder80 bottom_padder50">
        <div class="container">

            <h1>Greška 403 - Nije Vam dozvoljen pristup ovoj strani.</h1>

        </div>
    </div>

@endsection

