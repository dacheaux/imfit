@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.workouts') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.workouts') }}
@endsection

@section('style')
<style>

</style>
@endsection

@section('content')

    <div class="box box-primary">
         <div class="box-header">
            <a href="{{ route('admin.workouts.create') }}" class="btn btn-primary btn-flat">
                  <i class="fa fa-plus"></i> &nbsp;&nbsp;
                {{ trans('admin_message.workouts.create_workout') }}
            </a>
        </div>
        <div class="box-body">
           <table class="table table-striped table-bordered dt-responsive" id="workouts-table" cellspacing="0" width="100%" role="grid">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('admin_message.workouts.name') }}</th>
                        <th>{{ trans('admin_message.workouts.workout_time') }}</th>
                        <th>{{ trans('admin_message.workouts.created') }}</th>
                        <th>{{ trans('admin_message.workouts.edit') }}</th>
                        <th>{{ trans('admin_message.workouts.delete') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(function() {

            var table = $('#workouts-table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: false,
                ordering: true,
                info: true,
                responsive: true,
                autoWidth: false,
                ajax: '{!! route('admin.workouts.data') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'workout_time', name: 'workout_time'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action0', name: 'action', orderable: false, searchable: false},
                    {data: 'action1', name: 'action1', orderable: false, searchable: false}
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

        });
    </script>
@endsection