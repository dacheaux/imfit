@extends('layouts.main')
@section('styles')
    <!-- Sweetalert -->
    <link rel="stylesheet" href="{{ asset('assets-admin/css/sweetalert.css') }}">
@endsection
@section('content')
    <!-- breadcrumb section start -->
    @include('partials.breadcrumb', ['pageTitle' => 'QR-Code'])
    <!-- gallery section start -->
    <div class="ff_gallery_wrapper top_padder80 bottom_padder50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="ff_heading">
                        <h1><span>Vaš</span> QR Code</h1>
                    </div>
                </div>

                <div class="container bootstrap snippet">


                    <div class="row ">
                        <div class="col-sm-12 text-center">
                                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(250)->generate($token)) !!} " class="avatar img-thumbnail">
                        </div>
                    </div>
                </div><!--/row-->

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Sweetalert -->
    <script src="{{asset('assets-admin/js/sweetalert-dev.js')}}"></script>
    @include('admin.partials._flash')
@endsection
