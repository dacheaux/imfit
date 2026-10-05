@extends('layouts.main')
@section('styles')

    <link rel="stylesheet" href="{{ asset('assets/css/timetable.css') }}">
    <style>
        #msg{
            width: 100%;
            height: 22px;
            display: block;
            margin-top: 15px;
            color: red;
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
        .tiva-timetable .timetable-list .timetable-content:last-child{
            border-bottom: 1px solid #d1d1d1;
        }
    </style>

    <!-- Sweetalert -->
    <link rel="stylesheet" href="{{ asset('assets-admin/css/sweetalert.css') }}">
@endsection
@section('content')
    <!-- breadcrumb section start -->
    @include('partials.breadcrumb', ['pageTitle' => 'termini'])
    <div class="ff_gallery_wrapper top_padder80 bottom_padder50">

        <div class="container">

            <div class="row">

                <div class="col-lg-12 col-md-12">

                    <div class="ff_heading">

                        <h1><span>Vaši </span> termini</h1>

                    </div>

                </div>

                <div class="col-lg-12 col-md-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#zakazani-termini" role="tab" data-toggle="tab">Zakazani termini</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#otkazani-termini" role="tab" data-toggle="tab">Otkazani termini</a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>



                <div class="tab-content col-md-12">

                    <div role="tabpanel" class="tab-pane fade in active show" id="zakazani-termini">

                        <br>

                        <h4>Zakazani termini</h4>

                            <div class="tiva-timetable">
                                <div class="timetable-list">

                                 @foreach($userTerms as $terms)

                                     @if($terms->user_delayed == 0)
                                         @if(isset($terms->term))
                                        <div class="timetable-day">
                                            <div class="timetable-header">{{ $terms->term->start_datetime->format('D')  }} <span>{{ $terms->term->start_datetime->format('d.M.Y.') }}</span></div>
                                            <div class="timetable-content">

                                                    <div class="timetable-item"><span class="timetable-color color-{{ $terms->term->start_datetime > \Carbon\Carbon::now() ? '1' : '2' }}"></span>
                                                    <span class="timetable-time">{{ $terms->term->start_datetime->format('H:i') }} - {{ $terms->term->end_datetime->format('H:i') }}</span>
                                                    <span class="timetable-name">{{ $terms->term->workout->name }}</span>
                                                    @if($terms->term->start_datetime > \Carbon\Carbon::now() )
                                                    <div class=" pull-right">
                                                        {{--<form class="form-delayed-submit" action="{{ url('/odlozi-termin/'.auth()->id()) }}" method="POST"--}}
                                                              {{--onsubmit="return confirm('{!! trans('admin_message.term.confirm')!!}')">--}}
                                                            {{--<input type="hidden" name="_method" value="POST">--}}
                                                            {{--<input type="hidden" name="_token" value="{!! csrf_token() !!}">--}}
                                                            {{--<input type="hidden" name="user_terms_id" value="{!! $terms->id !!}">--}}
                                                            {{--<input class="ff_button"--}}
                                                                   {{--type="submit"--}}
                                                                   {{--value="Otkaži termin">--}}
                                                        {{--</form>--}}
                                                        {{--<p style="color:#6699cc;">Trenutno nije moguće otkazivanje.</p>--}}
                                                        <button class="ff_button" type="submit"
                                                                data-user_id="{{ auth()->id() }}"
                                                                data-user_terms_id="{{ $terms->id }}" value="Otkaži termin">Otkaži termin</button>

                                                    </div>
                                                    @else
                                                    <div class=" pull-right">
                                                        <p style="color:#6699cc;">Završen</p>
                                                    </div>
                                                    @endif
                                                    <div class="clearfix"></div>
                                                </div>

                                            </div>
                                        </div>
                                         @endif
                                     @endif

                                @endforeach

                                     <br>

                                     {{ $userTerms->links() }}


                                </div>
                            </div>

                        <p>* Ako otkažete termin nećete biti u mogućnosti da ponovo zakažete isti, otkazan teremin biće Vam vraćen ukoliko otkažete u određeno vreme pre početka treninga.</p>



                    </div>


                    <div role="tabpanel" class="tab-pane fade" id="otkazani-termini">

                        <br>

                            <h4>Otkazani termini</h4>

                            <div class="tiva-timetable">
                                <div class="timetable-list">

                                    @foreach($userTerms2 as $terms2)

                                        @if($terms2->user_delayed != 0)
                                            @if(isset($terms2->term))
                                            <div class="timetable-day">
                                                <div class="timetable-header">{{ $terms2->term->start_datetime->format('D')  }} <span>{{ $terms2->term->start_datetime->format('d.M.Y.')  }}</span></div>
                                                <div class="timetable-content">
                                                    <div class="timetable-item"><span class="timetable-color color-4"></span>
                                                        <span class="timetable-time">{{ $terms2->term->start_datetime->format('H:i') }} - {{ $terms2->term->end_datetime->format('H:i') }}</span>
                                                        <span class="timetable-name">{{ $terms2->term->workout->name }}</span>
                                                        <div class=" pull-right">
                                                            <p style="color:#e78b6c;">Otkazan</p>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endif

                                    @endforeach

                                        <br>
                                        {{ $userTerms2->links() }}

                                </div>
                            </div>



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
        (function(){

             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.ff_button').click(function(e) {

                e.preventDefault();
                var btn = $($(this)).prop('disabled', true).html('Sačekajte...');
                var user_id = $(this).data('user_id');
                var user_terms_id = $(this).data('user_terms_id');
                $.ajax({
                    url: '{!! route('frontterms.delayed') !!}',
                    type: 'POST',
                    dataType: 'json',
                    data: {user_id: user_id, user_terms_id: user_terms_id},
                    success: function (data) {

                        if (data.status == true) {
                            swal({
                                title: "Termin otkazan",
                                text: "Uspešno ste otkazali termin.",
                                type: "success",
                                confirmButtonText: 'Zatvori',
                                html: true
                            });
                            btn.html('Odložen');
                            setTimeout(function(){  window.location.reload(); }, 5000);
                        } else {
                            swal({
                                title: "Termin nije otkazan",
                                text: "Niste otkazali termin u odgovarajućem roku<br> pre početka treninga.",
                                type: "info",
                                confirmButtonText: 'Zatvori',
                                html: true
                            });
                            btn.prop('disabled', false).html('Otkaži termin');
                            //setTimeout(function(){  window.location.reload(); }, 3000);
                        }

                    },
                    fail: function () {
                        alert('Došlo je do greška! Pokušajte ponovo.');
                    }
                });

            });
        })();
    </script>

@endsection
