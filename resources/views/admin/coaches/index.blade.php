@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.coaches') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.coaches') }}
@endsection
@section('style')
    <link rel="stylesheet" href="{!! asset('assets-admin/admin2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') !!}"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
@endsection

@section('content')

    <div class="box box-primary">
        <div class="box-body">

            <div class="form-group">
                <form method="POST"  class="form-inline" id="coaches-form" role="form">

                    <div class="form-group">
                        {!! html()->label(trans('admin_message.term.from'), 'from') !!}
                        <div class='input-group date' id='from'>
                            <input type='text' class="form-control" name="from"
                            value="" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! html()->label(trans('admin_message.term.to'), 'to') !!}
                        <div class='input-group date' id='to'>
                            <input type='text' class="form-control" name="to"
                            value="" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <hr >
                    <div class="clo-md-12">

                        <div class="form-group">
                            <label for="workout_id">{{ trans('admin_message.term.workout') }}:</label>
                            <select name="workout_id" id="workout_id" class="form-control"
                                    >
                                <option value="">Izaberi trening</option>
                                @foreach($workouts as $workout)
                                    <option value="{{ $workout->id }}" {{ $workout->id == old('workout_id') ? 'selected' : ''}}>{{ $workout->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="trener_id">{{ trans('admin_message.term.coach') }}:</label>
                            <select name="trener_id" id="trener_id" class="form-control"
                                    >
                                <option value="">Izaberi trenera</option>
                                @foreach($coaches as $coach)
                                    <option value="{{ $coach->id }}" {{ $coach->id == old('trener_id') ? 'selected' : '' }}>{{ $coach->name }} {{ $coach->lastname }}</option>
                                @endforeach
                            </select>
                        </div>

                    <button type="submit" class="btn btn-primary">Filter</button>

                    </div>
                </form>
            </div>

            <hr>
                <p class="text-bold">Ukupno termina: <span class="badge bg-green" style="font-size: 14px;" id="terms">0</span></p>
                <p class="text-bold">Ukupno vežbača: <span class="badge bg-green" style="font-size: 14px;" id="user_terms">0</span></p>
            <hr>
            <table class="table table-striped table-bordered dt-responsive" id="coaches-table" cellspacing="0" width="100%"  role="grid">
                <thead>
                    <tr>
                        <th>Broj termina</th>
                        <th>Trener</th>
                        <th>Trening</th>
                        <th>Vežbača</th>
                        <th>Datum termina</th>
                        <th>#</th>
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
    <script>
        $(function() {

            var oTable = $('#coaches-table').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                lengthChange: false,
                ordering: true,
                info: true,
                autoWidth: false,
                dom: 'Bfrtip',
                lengthMenu: [[25, 100, -1], [25, 100, "all"]],
                pageLength: "all",
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
                    url: '{!! route('admin.coaches.data') !!}',
                    data: function (d, callback) {
                        d.from = $('input[name=from]').val();
                        d.to = $('input[name=to]').val();
                        d.workout_id = $('#workout_id').find(":selected").val();
                        d.trener_id = $('#trener_id').find(":selected").val();
                    },
                },
                drawCallback:function(settings)
                {
                    console.log(settings.json);
                    $('#terms').html(settings.json.recordsTotal);
                    if(settings.json.data.length > 0){
                        $('#user_terms').html(settings.json.data[0].total_users);
                    }else{
                        $('#user_terms').html(0);
                    }

                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'coach', name: 'coach'},
                    {data: 'workout', name: 'workout'},
                    {data: 'user_terms', name: 'user_terms'},
                    {data: 'start_datetime', name: 'start_datetime'},
                    {data: 'actions', name: 'actions'},
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

            $('#coaches-form').on('submit', function(e) {
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
                defaultDate:  '{!! old('from') ? old('from')  : Carbon\Carbon::now()->subDays(30) !!}'
            });

            $('#to').datetimepicker({
                locale: 'sr',
                defaultDate: '{!! old('to') ? old('to')  : Carbon\Carbon::now() !!}'
            });


        });
    </script>
@endsection
