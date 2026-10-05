@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.accounts') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.accounts') }}
@endsection

@section('style')
<style>

</style>
@endsection

@section('content')

    <div class="box box-primary">
        <div class="box-body">
           <table class="table table-striped table-bordered dt-responsive" id="account-table" cellspacing="0" width="100%" role="grid">
                <thead>
                    <tr>
                        <th>#KORISNIK ID</th>
                        <th>{{ trans('admin_message.account.balance') }}</th>
                        <th>{{ trans('admin_message.account.edit') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(function() {

            var table = $('#account-table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: false,
                ordering: true,
                info: true,
                responsive: true,
                autoWidth: false,
                ajax: '{!! route('admin.accounts.data') !!}',
                columns: [
                    {data: 'user_id', name: 'user_id'},
                    {data: 'balance', name: 'balance'},
                    {data: 'action0', name: 'action', orderable: false, searchable: false},
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
