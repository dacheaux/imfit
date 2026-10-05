@extends('admin.layout')

@section('title')
    Očitavanje QR koda
@endsection

@section('heading')
    Očitavanje QR koda
@endsection
@section('style')
    <link rel="stylesheet" href="{!! asset('assets-admin/admin2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') !!}"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
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
    </style>
@endsection

@section('content')

    <div class="box box-primary">
        <div class="box-body">

            <div class="form-group">
                <form method="POST"  class="form-inline" id="entrances-form" role="form">

                    <div class="form-group">
                        {!! Form::label('from', trans('admin_message.term.from')) !!}
                        <div class='input-group date' id='from'>
                            <input type='text' class="form-control" name="from"
                                   value="" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('to', trans('admin_message.term.to')) !!}
                        <div class='input-group date' id='to'>
                            <input type='text' class="form-control" name="to"
                                   value="" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <hr >
                    <div class="clo-md-12">

                        <div class="form-group">
                            <label for="user_id">{{ trans('admin_message.entrances.user_id') }}:</label>
                            <select name="user_id" id="user_id" class="form-control"
                            >
                                <option value="">Izaberi korisnika</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == old('id') ? 'selected' : ''}}>{{ $user->name . ' ' . $user->lastname}}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Filter</button>

                    </div>
                </form>
            </div>

            <hr>
            <p class="text-bold">Ukupno očitavanja: <span class="badge bg-green" style="font-size: 14px;" id="total-entrances">0</span></p>
            <hr>
            <table class="table table-striped table-bordered dt-responsive" id="entrances-table" cellspacing="0" width="100%"  role="grid">
                <thead>
                    <tr>
                        <th class="all">ID</th>
                        <th>Vreme očitavanja</th>
                        <th class="all">{{ trans('admin_message.entrances.username') }}</th>
                        <th>{{ trans('admin_message.entrances.type') }}</th>
                        <th class="all">Status plaćanja</th>
                        <th class="all">Status plana</th>
                        <th>Poruka</th>
                        <th>Viđeno</th>
                        <th>{{ trans('admin_message.entrances.delete') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(function() {

            $('#user_id').select2();

            var oTable = $('#entrances-table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: false,
                ordering: true,
                order: [ [0, 'desc'] ],
                info: true,
                autoWidth: false,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv',  'pdf', 'print',
                    {
                        extend: 'excel',
                        text: '<span class="fa fa-file-excel-o"></span> Excel Export',
                        exportOptions: {
                            modifier: {
                                search: 'applied',
                                page : 'all',
                                order: 'applied'
                            }
                        }
                    }
                ],
                ajax: {
                    url: '{!! route('admin.entrances.data') !!}',
                    data: function (d, callback) {
                        d.from = $('input[name=from]').val();
                        d.to = $('input[name=to]').val();
                        d.user_id = $('#user_id').find(":selected").val();
                    },
                },
                drawCallback:function(settings)
                {
                    console.log(settings.json);
                    $('#total-entrances').html(settings.json.recordsTotal);

                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'entry_time', name: 'entry_time'},
                    {data: 'username', name: 'username'},
                    {data: 'type', name: 'type'},
                    {data: 'payment_status', name: 'payment_status'},
                    {data: 'plan_status', name: 'plan_status'},
                    {data: 'message', name: 'message'},
                    {data: 'seen', name: 'seen'},
                    {data: 'action', name: 'action'},
                ],
                @if (App::getLocale() == 'sr')
                "language": {
                    "sProcessing":   "Učitavanje u toku...",
                    "sLengthMenu":   "Prikaži _MENU_ rezultata",
                    "sZeroRecords":  "Nije pronađen nijedan rezultat",
                    "sInfo":         "Prikaz _START_ do _END_ od ukupno _TOTAL_ rezultata",
                    "sInfoEmpty":    "Prikaz 0 do 0 od ukupno 0 rezultata",
                    "sInfoFiltered": "(filtrirano od ukupno _MAX_ rezultata)",
                    "sInfoPostFix":  "",
                    "sSearch":       "Pretraga:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Početna",
                        "sPrevious": "Prethodna",
                        "sNext":     "Sledeća",
                        "sLast":     "Poslednja"
                    }
                }
                @endif
            });

            $('#entrances-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });

        });
    </script>

    <script src="{!! asset('assets-admin/admin2/bower_components/moment/moment.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets-admin/admin2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}"></script>
    <script>
        $(function () {

            $('#from').datetimepicker({
                locale: 'sr',
                defaultDate:  '{!! old('from') ? old('from')  : Carbon\Carbon::now()->startOfDay() !!}'
            });

            $('#to').datetimepicker({
                locale: 'sr',
                defaultDate: '{!! old('to') ? old('to')  : Carbon\Carbon::now() !!}'
            });


        });
    </script>
@endsection
