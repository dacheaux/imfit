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
        .hreflink:hover{
            color: #bfd630!important;
        }
        .tiva-timetable .timetable-month .timetable-item .timetable-title{
            margin-bottom: 10px;
        }
        .tiva-timetable .timetable-month .timetable-item .timetable-name{
            word-break: break-word;
            color: #bebfc3!important;
            font-size: 11px;
        }
        .tiva-timetable .timetable-list .timetable-item .timetable-name {
            color: #bebfc3;
            word-break: break-word;
            font-size: 10px;
        }
        @media (max-width: 768px) {
            .timetable-desc h3{

            }
        }
    </style>
    {{--<link rel="stylesheet" href="{{ 'assets/css/custom-style.css' }}">--}}

@endsection

@section('content')

    <!-- breadcrumb section start -->

    @include('partials.breadcrumb', ['pageTitle' => 'Zakaži trening'])

    <!-- gallery section start -->

    <div class="ff_gallery_wrapper top_padder80 bottom_padder50">

        <div class="container">

            <div class="row">

                <div class="col-lg-12 col-md-12">

                    <div class="ff_heading">

                        <h1><span>Zakaži</span> trening</h1>

                    </div>

                </div>


                <div class="col-md-12">

                    <div class="row">

                        <div class="col-md-4 form-in">
                            <label for="workout_id">{{ trans('admin_message.term.workout') }}:</label>
                            <select name="workout_id" id="workout_id" class="form-control"
                            >
                                <option value="" disabled="disabled" selected>Selektuj vrstu treninga</option>
                                @foreach($workouts as $workout)
                                    <option value="{{ $workout->id }}" {{ $workout->id == old('workout_id') ? 'selected' : ''}}>{{ $workout->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="coach_id">Selektuj trenera:</label>
                            <select name="coach_id" id="coach_id" class="form-control"
                            >
                                <option value=""  selected>Svi</option>
                                @foreach($coaches as $coach)
                                    <option value="{{ $coach->id }}" {{ $coach->id == old('coach_id') ? 'selected' : ''}}>{{ $coach->name }} {{ $coach->lastname }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="tiva-timetable hidden-md-up" data-view="list" data-mode="month" data-start="monday"></div>

                    <div class="tiva-timetable hidden-sm-down" data-view="month" data-mode="month" data-start="monday"></div>


                </div>


                <div class="col-md-12">

                    <p>* Klikom na željeni termin, možete da zakažete trening. <br>

                        Ukoliko želite da otkažete zakazan termin, to možete da učinite na stranici <a class="hreflink" href="{{ url('moji-termini') }}" title="Moji termini">moji termini</a>.
                    </p>

                </div>


            </div>

        </div>

    </div>



@endsection



@section('scripts')

    <script src="{{ asset('assets/js/timetable.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery(document).ready(function () {

            $(document).on('change', '#workout_id, #coach_id',function() {

                jQuery('.tiva-timetable').each(function (index) {
                    // Set id for timetable
                    jQuery(this).attr('id', 'timetable-' + (index + 1));
                    var view = (typeof jQuery(this).attr('data-view') != 'undefined') ? jQuery(this).attr('data-view') : 'month';
                    if ((jQuery(this).attr('data-mode') == 'day') && ((view == 'week') || (view == 'list'))) {
                        var mode = 'day';
                    } else {
                        var mode = 'date';
                    }

                    var timetable_contain = jQuery(this);
                    jQuery.ajax({
                        url: '{!! route('frontterms.data') !!}',
                        dataType: 'json',
                        data:  { "workout_id": $("#workout_id").val(), "coach_id": $("#coach_id").val() },
                        beforeSend: function () {
                            timetable_contain.html('<div class="loading"><img src="{!! asset('assets/images/logo.png') !!}" /></div>');
                        },
                        success: function (data) {
                            // Init timetables variable
                            tiva_timetables = [];
                            for (var i = 0; i < data.length; i++) {
                                tiva_timetables.push(data[i]);
                            }
                            // Sort timetables by date
                            tiva_timetables.sort(sortByTime);
                            for (var j = 0; j < tiva_timetables.length; j++) {
                                tiva_timetables[j].id = j;
                            }
                            // Create timetable
                            var todayDate = new Date();
                            var date_start = (typeof timetable_contain.attr('data-start') != "undefined") ? timetable_contain.attr('data-start') : 'sunday';

                            if (date_start == 'sunday') {
                                var tiva_current_week = new Date(todayDate.setDate(tiva_current_date.getDate() - todayDate.getDay()));
                            } else {
                                var today_date = (todayDate.getDay() == 0) ? 7 : todayDate.getDay();
                                var tiva_current_week = new Date(todayDate.setDate(tiva_current_date.getDate() - today_date + 1));
                            }

                            createTimetable(timetable_contain, 'current', tiva_current_week, tiva_current_month, tiva_current_year);

                        }

                    });
                });

            });
        });

        /* 'login' => false,           // da li je ulogovan  T
             'slots' => false,            // da li ima slobodog mesta T
             'deadline' => false,            // da li je proslo 3h pre pocetka termina F
             'has_booked' => false,       // da li je vec bookirao taj termin F
             'delayed' => false,             // da li je otkazao taj termin  F
             'merbership_active' => false,  // da li je aktivna clanarina vezbaca T
             'inprogress_pause' => false,  // da li je pauzirana calanrina F
             'remain_terms' => false,   // da li ima ne iskoriscenih(preostalih) termina T*/

        function bookTermin(data) {
            var id = data.data('id');
            var msg = $('#msg');
            msg.removeClass('success');
            $('.ff_button').attr('disabled', true);
            $.ajax({
                url: '{!! route('frontterms.booking') !!}',
                type: 'POST',
                dataType: 'json',
                data: {id: id},
                success: function (data) {
                    msg.text('');
                    $('.ff_button').attr('disabled', false);
                    if (data.booked == false) {
                        if (data.login == false){
                            msg.text('Morate biti prijavljeni da biste zakazali termin.');
                        }else {
                            if(data.deadline == true){
                                msg.text('Termin nije moguće zakazati 3h pre početka treninga.');
                            }
                            if(data.slots == false){
                                msg.text('Izabran termin nema slobodnih mesta.');
                            }
                            if(data.has_booked == true){
                                msg.text('Već ste zakazali izabran termin.');
                            }
                            if(data.delayed == true){
                                msg.text('Nije moguće zakazivanje. Izabran termin ste već otkazali.');
                            }
                            if(data.plan == false){
                                msg.text('Nije moguće zakazivanje. Nemate paket.');
                            }
                        }

                    }else {
                        msg.addClass('success').text('Uspešno ste zakazali termin.');

                    }
                },
                fail: function () {
                    msg.text('Nije moguće zakazivanje. Probaj opet kasnije.');
                }
            });
        }

    </script>
    <script type="text/javascript">
        setTimeout(function () { location.reload(true); }, 600000);
    </script>
@endsection
