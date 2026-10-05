@extends('layouts.main')
@section('styles')
    <style>
        #msg {
            width: 100%;
            height: 22px;
            display: block;
            margin-top: 15px;
            color: red;
        }
        .success {
            color: #bfd630 !important;
        }
        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
            color: #ffffff;
            background-color: #bfd630;
            border-color: #d1d1d1 #d1d1d1 #d1d1d1;
        }
        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 18px;
            color: #fff;
            background-color: #212731;
            border: 1px solid #d1d1d1;
        }
        .page-item.disabled .page-link {
            color: #d1d1d1;
            pointer-events: none;
            cursor: not-allowed;
            background-color: #818286;
            border-color: #d1d1d1;
        }
        .page-item.active .page-link {
            z-index: 2;
            color: #fff;
            background-color: #bfd630;
            border-color: #d1d1d1;
        }
        .page-link:focus, .page-link:hover {
            color: #bfd630;
            text-decoration: none;
            background-color: #212731;
            border-color: #d1d1d1;
        }
        .approved-table {
            color: #fff;
        }
        .bg-success {
            background-color: #bfd630 !important;
        }
        .btn-success {
            background-color: #bfd630;
            border-color: #bfd630;
        }
        .btn-success:hover, .btn-info:hover {
            background-color: #212731;
            border-color: #d1d1d1;
        }
        .btn-success.disabled, .btn-success:disabled {
            background-color: #bfd630;
            border-color: #bfd630;
        }
    </style>
    <!-- Sweetalert -->
    <link rel="stylesheet" href="{{ asset('assets-admin/css/sweetalert.css') }}">
@endsection
@section('content')
    <!-- breadcrumb section start -->
    @include('partials.breadcrumb', ['pageTitle' => 'plaćanja'])
    <div class="ff_gallery_wrapper top_padder80 bottom_padder50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="ff_heading">
                        <h1><span>Vaša </span> plaćanja</h1>
                    </div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/racun') }}" >Račun</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/poruceni-planovi') }}" >Poručeni planovi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ url('/placanja') }}" >Plaćanja</a>
                            </li>
                        </ul>
                    <br>
                </div>
                <div class="col-lg-10 col-xl-12">
                    @if(count($orders))
                    <div class="table-responsive">
                        <table class="table table-bordered table-light">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;">#</th>
                                <th scope="col" style="text-align: center;">Slika proizvoda</th>
                                <th scope="col" style="text-align: center;">Naziv proizvoda</th>
                                <th scope="col" style="text-align: center;">Količina</th>
                                <th scope="col" style="text-align: center;">Iznos</th>
                                <th scope="col" style="text-align: center;">Status</th>
                                <th scope="col" style="text-align: center;">Datum</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr class="{{ $order->status == 0 ? "bg-danger" : '' }}">
                                    <th style="color:#fff;text-align: center; vertical-align: middle;">{{ $order->id }}.</th>
                                    @foreach($order->products as $product)
                                        <th  style="text-align: center; vertical-align: middle;" width="150">
                                            <div class="product-image">
                                                <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}" title="{{ $product->product_name }}" class="img-fluid">
                                            </div>
                                        </th>
                                        <th style="color: #fff;text-align: center;vertical-align: middle;">{{ $product->product_name }}</th>
                                    @endforeach
                                    <th style="text-align: center;vertical-align: middle;">{{ $order->order_qty }}</th>
                                    @if($order->status == 1)
                                        <th style="color: #fff;text-align: center;vertical-align: middle;">- {{ number_format($order->order_amount , 2) }} rsd</th>
                                    @else
                                        <th style="color: #fff ;text-align: center;vertical-align: middle;">---</th>
                                    @endif
                                    @if($order->status == 1)
                                    <th style="color: #bfd630;text-align: center;vertical-align: middle;">Uspešno</th>
                                    @else
                                    <th style="color: #fff ;text-align: center;vertical-align: middle;">Neuspešno</th>
                                    @endif
                                    <th style="color: #fff ;vertical-align: middle;">{{ $order->created_at }}</th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links() }}
                        @else
                            <p style="color: #bfd630;">Trenutno nemate plaćanja.</p>
                        @endif

                    </div>
                </div>



                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Sweetalert -->
    <script src="{{asset('assets-admin/js/sweetalert-dev.js')}}"></script>
    @include('admin.partials._flash')
    <script>
        $(function () {
            $('.plan-info').hide();
            $('#account_plan_id').change(function () {
                $('.plan-info').hide();
                $('#plan' + $(this).val()).show();
            });
        });
    </script>
@endsection
