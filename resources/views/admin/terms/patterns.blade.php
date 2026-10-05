@extends('admin.layout2')
@section('title')
    {{ trans('admin_message.sidebar.terms') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.terms') }}
@endsection
@section('style')
    <link rel="stylesheet"
          href="{!! asset('assets-admin/admin2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}"/>
    <style>
        #start_datetime input.form-control[readonly] {
            background-color: #fff;
            color: #555;
            cursor: pointer;
        }
        #start_datetime .input-group-addon {
            cursor: pointer;
            background-color: #fff;
            color: #555;
        }
        /* Widen calendar dropdown to almost match input width */
        .datepicker-dropdown.datepicker {
            width: 320px;
            @media (max-width: 767px) {
                position: fixed;
                left: calc((100vw - 320px) / 2) !important;
            }
        }
        .datepicker-dropdown.datepicker table {
            width: 100%;
        }
        .datepicker-dropdown.datepicker table tr td,
        .datepicker-dropdown.datepicker table tr th {
            width: auto;
        }
    </style>
@endsection
@section('content')

    <div class="col-md-4">
        <div class="box box-primary">

            <div class="box-header">

            </div>

            <div class="box-body">
                {!! Form::open(['url'=> 'admin/terms/apply-term-patterns', 'action' => 'POST']) !!}
                <div class="col-md-12">
                    <p>Odabirom šablona, termini će se primeniti na ceo dan <br> izabranog datuma. <i class="fa fa-info-circle"></i> </p>
                    <div class="form-group">
                        <label for="pattern_id">{{ trans('admin_message.patterns.pick') }}:</label>
                        <select name="pattern_id" id="pattern_id" class="form-control"
                                required>
                            <option  selected disabled>Izaberi šablon</option>
                            @foreach($termpatterns as $termpattern)
                                <option value="{{ $termpattern->id }}" >{{ $termpattern->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        {!! Form::label('start_datetime', trans('admin_message.term.apply_dates')) !!}
                        <div class="input-group date" id="start_datetime">
                            <input type="text" class="form-control" id="apply_dates_input" readonly
                                   placeholder="{{ trans('admin_message.term.apply_dates') }}" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                        <p class="help-block">Klik na datum dodaje/uklanja. Možete birati više dana i prelaziti mesece.</p>
                    </div>

                    <div class="form-group pull-right">
                        {!! Form::submit( trans('admin_message.term.applyTermPatterns'), ['class' => 'btn btn-primary btn-flat']) !!}
                        <a href="{!! url('admin/terms') !!}" title="{{ trans('admin_message.cancel') }}"
                           class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
                    </div>

                    {!! Form::close() !!}

                </div>

            </div>

        </div>


    </div>
    <div class="col-md-6 col-sm-12">
        <div class="box box-default">

            <div class="box-header">
                <h3 class="text-center">Pregled odabranog šablona</h3>
            </div>

            <div class="box-body">

                @foreach($termpatterns as $termpattern)
                    <table class="table table-striped termpattern" id="termpattern{{ $termpattern->id }}">
                        <tbody>
                        <tr style="visibility: hidden;">
                            <td width="35%"></td>
                            <td width="65%"></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Naziv šablona:</td>
                            <td>{{ $termpattern->name }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Vrsta Treninga:</td>
                            <td>{{ $termpattern->workout->name }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Trener:</td>
                            <td>{{ $termpattern->coach->name . ' ' . $termpattern->coach->lastname }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Broj mesta:</td>
                            <td>{{ $termpattern->slots }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Opis:</td>
                            <td>{{ $termpattern->note }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Termini:</td>
                            <td>
                                <br>
                                @foreach(unserialize($termpattern->hours) as $term )
                                    <div class="form-group">
                                        <p>{{ $term->format('H:i') }}
                                            - {{ $term->addMinutes($termpattern->workout->workout_time)->format('H:i') }}</p>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @endforeach

            </div>

        </div>

    </div>


        @endsection

        @section('scripts')
            <script type="text/javascript"
                    src="{!! asset('assets-admin/admin2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}"></script>
            <script type="text/javascript"
                    src="{!! asset('assets-admin/admin2/bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.sr-latin.js') !!}"></script>
            <script>
                $(function () {
                    $('#start_datetime input').datepicker({
                        language: 'sr-latin',
                        format: 'dd.mm.yyyy',
                        multidate: true,
                        startDate: new Date(),
                        todayHighlight: true
                    });
                    $('#start_datetime .input-group-addon').on('click', function (e) {
                        e.preventDefault();
                        $('#start_datetime input').datepicker('show');
                    });
                });

                $(function () {
                    $('.termpattern').hide();
                    $('#pattern_id').change(function () {
                        $('.termpattern').hide();
                        var val = $(this).val();
                        if (val) $('#termpattern' + val).show();
                    });
                });

                $(function () {
                    var form = $('form[action*="apply-term-patterns"]');
                    var submitted = false;
                    form.on('submit', function (e) {
                        if (submitted) return true;
                        e.preventDefault();
                        var dates = $('#start_datetime input').datepicker('getDates');
                        if (!dates || dates.length === 0) {
                            alert('Izaberite bar jedan datum za primenu termina.');
                            return false;
                        }
                        form.find('input[name="start_dates[]"]').remove();
                        dates.forEach(function (d) {
                            form.append($('<input type="hidden" name="start_dates[]">').val(moment(d).format('YYYY-MM-DD')));
                        });
                        submitted = true;
                        form.off('submit').submit();
                    });
                });
            </script>
@endsection