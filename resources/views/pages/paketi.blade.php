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
    @include('partials.breadcrumb', ['pageTitle' => 'članarina'])
    <div class="ff_gallery_wrapper top_padder80 bottom_padder50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="ff_heading">
                        <h1><span>Vaša </span> članarina</h1>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#moji-paketi" role="tab" data-toggle="tab">Paketi
                                treninga</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#naruci-paket" role="tab" data-toggle="tab">Naruči paket</a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="tab-content col-md-12">
                    <div role="tabpanel" class="tab-pane fade in active show" id="moji-paketi">
                        <br>
                        <h3 class="bottom_padder20">Moji paketi</h3>
                        @if(count($userPlans))
                            <div class="table-responsive">
                                <table class="table table-bordered table-light">
                                    <thead>
                                    <tr>
                                        <th scope="col">Paket</th>
                                        <th scope="col">Preostalo termina</th>
                                        <th scope="col">Naručen</th>
                                        <th scope="col">Ističe</th>
                                        <th scope="col">Pauza od</th>
                                        <th scope="col">Uplaćen</th>
                                        <th scope="col">Odobren</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($userPlans as $p)
                                        <tr class="{{ $p->approved ? 'approved-table' : ''}}">
                                            <th>{{ $p->plan->name }}</th>
                                            <th style="color: #bfd630;">{{ $p->terms_number }}</th>
                                            <th>{{ $p->created_at }}</th>
                                            <th>
                                                {{ $p->active ? $p->expired_time->format('d.m.Y.') : '-' }}
                                            </th>
                                            <th>{{ $p->pause_flag ? $p->pause_from->format('d.m.Y.') : '-' }}</th>
                                            <th class="{{ $p->paid ? 'bg-success' : 'bg-danger'}}">{{ $p->paid ? 'Plaćeno' : 'Neplaćeno' }}</th>
                                            <th class="{{ $p->approved ? 'bg-success' : 'bg-danger'}}">{{ $p->approved ? 'Paket odobren' : 'Na čekanju' }}</th>
                                            <th>
                                                @if( $p->approved )
                                                    <div class="form-group">
                                                        @if(!$p->active)
                                                            {{ html()->form('POST', url('aktiviraj-paket'))->open() }}
                                                            {{ html()->hidden('id', $p->id)->forgetAttribute('id') }}
                                                            <button type="submit"
                                                                    onclick="return confirm('Da li ste sigurni?')"
                                                                    class="btn btn-{{ $p->active ? 'success' : 'success'}}" {{ $p->active ? 'disabled':'' }}>
                                                                {{ $p->active ? 'U TOKU' : 'AKTIVIRAJ'}}
                                                            </button>
                                                            {{ html()->form()->close() }}
                                                        @elseif($p->active && $p->expired_time <= \Carbon\Carbon::now())
                                                        @else
                                                            @if(!$p->pause_flag)
                                                                <button type="button"
                                                                        class="btn btn-{{ $p->active ? 'success' : 'success'}}" {{ $p->active ? 'disabled':'' }}>
                                                                    {{ $p->active ? 'U TOKU' : 'AKTIVIRAJ'}}
                                                                </button>
                                                            @else
                                                                <button type="button"
                                                                        class="btn btn-{{ $p->active ? 'success' : 'success'}}" {{ $p->active ? 'disabled':'' }}>
                                                                    {{ $p->active ? 'PAUZIRAN' : 'AKTIVIRAJ'}}
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    @if( $p->active )
                                                        <div class="form-group">
                                                            {{--@if($p->pause_flag == 1)--}}
                                                                {{--<button type="button"--}}
                                                                        {{--class="btn btn-{{ $p->pause_flag ? 'info' : 'info'}}" {{ $p->pause_flag ? 'disabled':'' }}>--}}
                                                                    {{--{{ $p->pause_flag ? 'PAUZA U TOKU' : 'PAUZA'}}--}}
                                                                {{--</button>--}}
                                                            {{--@endif--}}
                                                            {{--@if( $p->pause_flag == 0 && $p->expired_time >= \Carbon\Carbon::now())--}}
                                                                {{--{{ html()->form('POST', url('pauziraj-paket'))->open() }}--}}
                                                                {{--{{ html()->hidden('id', $p->id)->forgetAttribute('id') }}--}}
                                                                {{--<button type="submit"--}}
                                                                        {{--onclick="return confirm('Da li ste sigurni?')"--}}
                                                                        {{--class="btn btn-{{ $p->pause_flag ? 'info' : 'info'}}" {{ $p->pause_flag ? 'disabled':'' }}>--}}
                                                                    {{--{{ $p->pause_flag ? 'PAUZA U TOKU' : 'PAUZA'}}--}}
                                                                {{--</button>--}}
                                                                {{--{{ html()->form()->close() }}--}}
                                                            {{--@endif--}}
                                                            @if($p->pause_flag == 0)
                                                                @if( $p->expired_time > \Carbon\Carbon::now())
{{--                                                                    <form action="{!! route('userplans.setpauseon', $p->id) !!}"--}}
{{--                                                                          method="POST"--}}
{{--                                                                          onsubmit="return confirm('{!! trans('admin_message.userplans.confirm2')!!}'+' {!! $p->plan->name !!}?')">--}}
{{--                                                                        <input type="hidden" name="_method"--}}
{{--                                                                               value="POST">--}}
{{--                                                                        <input type="hidden" name="user_id"--}}
{{--                                                                               value="{{ $p->user_id }}">--}}
{{--                                                                        <input type="hidden" name="_token"--}}
{{--                                                                               value="{!! csrf_token() !!}">--}}
{{--                                                                        <input class="btn btn-sm btn-flat btn-info uppercase"--}}
{{--                                                                               type="submit"--}}
{{--                                                                               value="{{ trans('admin_message.userplans.setpause') }}">--}}
{{--                                                                    </form>--}}
                                                                    <span class="tag label label-success">AKTIVAN</span>
                                                                @else
                                                                    <span class="tag label label-danger">Plan istekao</span>
                                                                @endif
                                                            @else
{{--                                                                <form action="{!! route('userplans.setpauseoff', $p->id) !!}"--}}
{{--                                                                      method="POST"--}}
{{--                                                                      onsubmit="return confirm('{!! trans('admin_message.userplans.confirm3')!!}'+' {!! $p->plan->name !!}?')">--}}
{{--                                                                    <input type="hidden" name="_method" value="POST">--}}
{{--                                                                    <input type="hidden" name="user_id"--}}
{{--                                                                           value="{{ $p->user_id }}">--}}
{{--                                                                    <input type="hidden" name="_token"--}}
{{--                                                                           value="{!! csrf_token() !!}">--}}
{{--                                                                    <input class="btn btn-sm btn-flat btn-warning uppercase"--}}
{{--                                                                           type="submit"--}}
{{--                                                                           value="{{ trans('admin_message.userplans.setpauseoff') }}">--}}
{{--                                                                </form>--}}
                                                                <span class="tag label label-warning">PAUZIRAN</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endif
                                            </th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $userPlans->links() }}
                        @else
                            <p style="color: #bfd630;">Trenutno nemate paket.</p>
                        @endif
                        <p class="pt-4">
                            Ovde možeš da imaš uvid u tvoje pakete treninga, posle odobrenja od strane administratora,
                            moći ćeš da aktiviraš paket i da imaš uvid,
                            u preostale termine (treninge) kao i do kada traje članarina odnosno paket koji aktiviraš.
                            Pakete isto možeš
                            da pauziraš, a mi ćemo ti vratiti dane na datum isteka paketa koliko si bio na pauzi. U toku
                            pauze možeš da odlažeš termine,
                            ali ne možeš da zakazuješ.
                        </p>
                        <div class="clearfix"></div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="naruci-paket">
                        <br>
                        <h3>Naruči nov paket treninga</h3>
                        <div class="container" style="padding: 0;">
                            {!! html()->form('POST', url('poruci-paket'))->attributes(['id' => 'paket-form'])->open() !!}
                            <div class="col-md-4 form-group top_padder20" style="padding-left: 0; padding-right: 0;">
                                <label for="plan_id">Paketi:</label>
                                <select name="plan_id" id="plan_id" class="form-control" required>
                                    <option value="">Izaberi paket</option>
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="top_padder20">
                                <div class="ff_pricing_wrapper">
                                    @foreach($plans as $plan)
                                        <div class="plan-info" id="plan{{$plan->id}}">
                                            <div class="col-lg-4 col-sm-12" style="padding: 0;">
                                                <div class="ff_pricing_box">
                                                    <div class="ff_pricing_head">
                                                        <h5>{{$plan->name}}</h5>
                                                        <h1>{{ $plan->price }} RSD</h1>
                                                    </div>
                                                    <div class="ff_pricing_body">
                                                        <ul>
                                                            <li>Paketa treninga za: <br>
                                                                <h5>{{ $plan->workout->name }}</h5>
                                                            </li>
                                                            <li>Trajanje paketa: <br>
                                                                <h5>{{ $plan->plan_duration }} @if ($plan->plan_duration > 1)
                                                                        Dana @else Dan @endif</h5></li>
                                                            <li>Ukupno treninga: <br>
                                                                <h3>{{ $plan->workouts_number }}</h3></li>
                                                        </ul>
                                                        <div class="form-group">
                                                            {!! html()->submit('Naruči')->attributes(['class' => 'ff_button', 'onclick' => 'return confirm("Da li ste sigurni da želite da poručite: '.$plan->name.'?")']) !!}
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
                            {!! html()->form()->close() !!}
                        </div>
                        <p>
                            Ovde možeš da naručiš nov paket treninga, posle odobrenja od strane administratora, moći ćeš
                            da aktiviraš paket i da imaš uvid,
                            u preostale termine (treninge) kao i do kada traje članarina odnosno paket koji aktiviraš.
                            Pakete isto možeš
                            da pauziraš, a mi ćemo ti vratiti dane na datum isteka paketa koliko si bio na pauzi. U toku
                            pauze možeš da odlažeš termine,
                            ali ne možeš da zakazuješ.
                        </p>
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
            $('#plan_id').change(function () {
                $('.plan-info').hide();
                $('#plan' + $(this).val()).show();
            });
        });
    </script>
@endsection
