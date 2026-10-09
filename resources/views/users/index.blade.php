@extends($area.'.layout')

@section('title')
    {{ trans('admin_message.sidebar.users') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.users') }}
@endsection
@section('style')
   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
@endsection
@section('content')

    <div class="box box-primary">
        <div class="box-header">
            <a href="{{ route($area.'.users.create') }}" class="btn btn-primary btn-flat">
                <i class="fa fa-user-plus"></i> &nbsp;&nbsp;
                {{ trans('admin_message.users.create_user') }}
            </a>
        </div>
        <div class="box-body">
            <table class="table table-striped table-bordered dt-responsive" id="users-table" cellspacing="0" width="100%"  role="grid">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>QR</th>
                    <th>{{ trans('admin_message.users.name') }}</th>
                    <th>{{ trans('admin_message.users.lastname') }}</th>
                    <th>{{ trans('admin_message.users.email') }}</th>
                    <th>{{ trans('admin_message.users.birth') }}</th>
                    <th>{{ trans('admin_message.users.phone') }}</th>
                    <th>{{ trans('admin_message.users.created') }}</th>
                    <th>{{ trans('admin_message.users.edit') }}</th>
                    <th>{{ trans('admin_message.users.delete') }}</th>
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

            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                ordering: true,
                info: true,
                autoWidth: false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3],
                            stripHtml: false
                        }
                    }
                ],
                ajax: '{!! route($area.'.users.data') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'qrcode', name: 'qrcode', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'lastname', name: 'lastname'},
                    {data: 'email', name: 'email'},
                    {data: 'birth', name: 'birth'},
                    {data: 'phone', name: 'phone'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
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
