@extends('layouts.main')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
    <style>
        .select2-selection__rendered {
            line-height: 31px !important;
            border-radius: 0;
        }
        .select2-container .select2-selection--single {
            height: 35px !important;
            border-radius: 0;
        }
        .select2-selection__arrow {
            height: 34px !important;
            border-radius: 0;
        }
        .select2-container--default .select2-results__option[aria-disabled=true] {
            color: #999;
            background-color: #eee;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #000;
        }
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable{
            color: #000;
        }
        .select2-results__options{
            color: #000;
        }
    </style>
    <style>
        .opt-disabled{
            background: #ddd;
        }
        /* display this row with flex and use wrap (= respect columns' widths) */

        .row-flex {
            display: flex;
            flex-wrap: wrap;
        }


        /* vertical spacing between columns */

        .row-flex [class*="col-"] {
            margin-bottom: 20px;
        }

        .row-flex .content {
            height: 100%;
            padding: 10px 10px 5px;
        }

        .product-image{

            padding: 10px 0;
        }
        .product-image img {
            margin: 0 auto;
            display: block;
        }

        .product_info h3 {
            text-align: center;
            font-size: 24px;
            height: 50px;
            overflow: hidden;
            word-break: break-word;
        }
        .product_info p {
            text-align: center;
            padding-bottom: 0;
        }
        .product_info .product-price {
            color: #bfd630;
            padding-bottom: 10px;
        }
        .product_info .product-price{
            font-size: 26px;
            text-align: center;
        }
        .product_info .product-price  span{
            font-size: 14px;
            color: #fff;
        }
        .product-button{
            font-weight: bold;
            text-align: center;
            color: #fff;
            padding: 0 25px;
        }

        .success{
            color: #bfd630!important;
        }
        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link{
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
        .approved-table{
            color: #fff;
        }
        .bg-success {
            background-color: #bfd630 !important;
        }
        .btn-success{
            background-color: #bfd630;
            border-color: #bfd630;
        }
        .btn-success:hover, .btn-info:hover{
            background-color: #212731;
            border-color: #d1d1d1;
        }
        .btn-success.disabled, .btn-success:disabled {
            background-color: #bfd630;
            border-color: #bfd630;
        }
        @media (max-width: 575px) {
            .product-image img{
                width: 200px;
                margin: 0 auto;
            }
            .row-flex .content {
                //border: 1px solid #818286;
                padding: 15px;
            }

        }
        .modal-body  .product-image img{
            max-width: 300px;
            margin: 0 auto;
        }
        .modal-body h3, .modal-body p{
            color: #0a0a0a;
            padding-bottom: 10px;
        }
        .modal-body .product-price {
            color: #0a0a0a;
            font-weight: 600;
            padding-bottom: 10px;
            font-size: 32px;
        }
        .modal-body .product-price span{
            color: #0a0a0a;
            padding-bottom: 10px;
            font-size: 18px;
        }
        .modal-body .product-button2 {
            background: #bfd630;
            color: #fff;
        }
        .modal-body .product-button2:hover {
            transform: scale(1.1);
        }
    </style>
@endsection
@section('content')

    <!-- breadcrumb section start -->
    @include('partials.breadcrumb', ['pageTitle' => 'Shop'])

    <!-- blog section start -->
    <div class="ff_blog_wrapper top_padder80 bottom_padder30">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    @include('partials.shop-sidebar')

                </div>
                <div class="col-md-12">
                    <div class="row row-flex">

                        @include('shop._products')

                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('scripts')
    <script>
        (function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('.product-button2').click(function(e) {


                if(confirm('Da li ste sigurni?')) {
                    e.preventDefault();
                    var btn = $($(this)).prop('disabled', true).html('Očitajte QR kod');
                    var user_id = $(this).data('user_id');
                    var product_id = $(this).data('product_id');
                    var order_amount = $(this).data('order_amount');
                    var msgs = $(".msgs" + product_id);
                    $.ajax({
                        url: '{!! route('shop.order') !!}',
                        type: 'POST',
                        dataType: 'json',
                        data: {user_id: user_id, product_id: product_id, order_amount: order_amount},
                        success: function (data) {

                            if (data.status == true) {
                                msgs.html("Hvala na kupovini!");
                                btn.prop('disabled', true).html('USPEŠNO');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 5000);
                            } else {
                                msgs.html(data.message);
                                btn.prop('disabled', false).html('PLAĆANJE');
                                setTimeout(function () {
                                    msgs.html("");
                                }, 3000);
                            }

                        },
                        fail: function () {
                            alert('Došlo je do greška! Pokušajte ponovo.');
                        }
                    });

                }

            });
        })();
    </script>
@endsection
