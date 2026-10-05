@extends('layouts.main')
@section('styles')
    <!-- Sweetalert -->
    <link rel="stylesheet" href="{{ asset('assets-admin/css/sweetalert.css') }}">
@endsection
@section('content')
    <!-- breadcrumb section start -->
    @include('partials.breadcrumb', ['pageTitle' => 'Članarina'])
    <!-- gallery section start -->
    <div class="ff_gallery_wrapper top_padder80 bottom_padder50">
        <div class="container">
            <div class="col-lg-12 col-md-12">
                <div class="ff_heading">
                    <h1><span>Vaša</span> Članarina</h1>
                </div>
            </div>
            <div class="col-md-6">
                <div class="pt-5">
                    <h5>Br. članarine: FA - {{ $membership->user_id }}</h5>
                    <h5>Broj termina: {{ $membership->terms_number }}</h5>
                    <h5>Članarina ističe: {{ $membership->expired_time }}</h5>
                    <h5>Aktivna pazua 7 dana:
                        @if( $membership->pause_time <= \Carbon\Carbon::now()->addDays(7)  || $membership->pause_flag == 1)
                          Da
                        @else
                          Ne
                        @endif
                    </h5>
                     @if( ! $membership->pause_time <= \Carbon\Carbon::now()->addDays(7)  || $membership->pause_flag == 0)
                              <form action="{{ url('/odlozi-termin/'.auth()->id()) }}" method="POST"
                                      onsubmit="return confirm('{!! trans('admin_message.term.confirm')!!}')">
                                    <input type="hidden" name="_method" value="POST">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <input type="hidden" name="user_terms_id" value="{!! $terms->id !!}">
                                    <input class="ff_button"
                                           type="submit"
                                           value="Otkaži termin">
                                </form>
                     @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Sweetalert -->
    <script src="{{asset('assets-admin/js/sweetalert-dev.js')}}"></script>
    @include('admin.partials._flash')
@endsection