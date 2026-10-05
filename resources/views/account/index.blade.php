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
    @include('partials.breadcrumb', ['pageTitle' => 'račun'])
    <div class="ff_gallery_wrapper top_padder80 bottom_padder50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="ff_heading">
                        <h1><span>Vaš </span> račun</h1>
                    </div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('/racun') }}" >Račun</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/poruceni-planovi') }}" >Poručeni planovi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/placanja') }}" >Plaćanja</a>
                        </li>
                    </ul>
                    <br>
                </div>
                <div class="col-lg-6 offset-lg-3">

                    <div class="table-responsive">
                        <table class="table table-bordered table-light">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;">Stanje na računu</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th style="color: #bfd630;text-align: center;">{{ number_format($account->balance , 2) }} rsd</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12 text-center">
                    <br>
                    <h3>Dopuni svoj račun</h3>
                    <div class="container" style="padding: 0;">
                        {!! Form::open(['method'=>'post','url'=>'poruci-plan-racun', 'id'=>'paket-form'] ) !!}
                        <div class="col-md-4 offset-lg-4 form-group top_padder20" style="padding-left: 0; padding-right: 0;">
                            <select name="account_plan_id" id="account_plan_id" class="form-control" required>
                                <option value="">Izaberi plan</option>
                                @foreach($accountplans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->plan_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="top_padder20">
                            <div class="ff_pricing_wrapper">
                                @foreach($accountplans as $plan)
                                    <div class="plan-info" id="plan{{$plan->id}}">
                                        <div class="col-lg-4 offset-lg-4 col-sm-12" style="padding: 0;">
                                            <div class="ff_pricing_box">
                                                <div class="ff_pricing_body">
                                                    <ul>
                                                        <li>Dopuna u izonsu od: <br>
                                                            <h5>{{ $plan->deposit_amount }} RSD</h5>
                                                        </li>
                                                    </ul>
                                                    <div class="form-group">
                                                        {!! Form::submit('Naruči', ['class' => 'ff_button' , 'onclick'=>'return confirm("Da li ste sigurni da želite da poručite: '.$plan->plan_name.'?")']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="pt-2">
                            @include('partials.errors')
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <p>
                        Ovde možeš da naručiš plan kako bi dopunio svoje stanje na računu.<br class="d-none d-md-block">
                        Nakon odobrenja administratora, tvoj račun će biti uvećan za iznos <a href="{{ url('/poruceni-planovi') }}" style="text-decoration: underline;">poručenog plana.</a> <br class="d-none d-md-block">
                        Očitavanjem svog QR code-a, moći ćeš da kupuješ nešto iz našeg šopa (frižider-a).
                    </p>
                    <div class="clearfix"></div>
                </div>

                </div>
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
