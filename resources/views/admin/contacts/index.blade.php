@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.contact') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.contact') }}
@endsection

@section('style')
<style>
    table.dataTable tbody td:nth-child(5) {
      word-break: break-word;
      vertical-align: top;
    }
</style>
@endsection

@section('content')

    <div class="box box-primary">
        <div class="box-body">
            <table class="table table-striped table-bordered dt-responsive"  cellspacing="0" width="100%"  id="contacts-table" role="grid">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('admin_message.contacts.name') }}</th>
                    <th>{{ trans('admin_message.contacts.email') }}</th>
                    <th>{{ trans('admin_message.contacts.theme') }}</th>
                    <th>{{ trans('admin_message.contacts.question') }}</th>
                    <th>{{ trans('admin_message.contacts.ip_adress') }}</th>
                    <th>{{ trans('admin_message.contacts.created') }}</th>
                    <th>{{ trans('admin_message.contacts.seen') }}</th>
                    <th>{{ trans('admin_message.contacts.delete') }}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(function() {

            var table = $('#contacts-table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: false,
                ordering: true,
                info: true,
                responsive: true,
                autoWidth: false,
                ajax: '{!! route('admin.contacts.data') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'theme', name: 'theme'},
                    {data: 'question', name: 'question'},
                    {data: 'ip_adress', name: 'ip_adress'},
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


            // Ajax
            $('body').on(  'change', ':checkbox',function() {

                $(this).hide().parent().append('<i class="fa fa-refresh fa-spin"></i>');

                var token = $('input[name="_token"]').val();
                var seen = $(this).attr('name');

                if(seen == 'seen'){
                    $(this).parents('tr').toggleClass('danger').toggleClass('default');
                }
                $.ajax({
                    url: '/admin/contacts/' + this.value,
                    type: 'PUT',
                    data: seen + "=" + this.checked + "&_token=" + token
                })
                        .done(function() {
                            $('.fa-spin').remove();
                            $('input[type="checkbox"]:hidden').show();
                            table.ajax.reload();
                        })
                        .fail(function() {
                            $('.fa-spin').remove();
                            var chk = $('input[type="checkbox"]:hidden');
                            if(seen == 'seen') {
                                chk.parents('tr').toggleClass('danger').toggleClass('default');
                            }
                            chk.show().prop('checked', chk.is(':checked') ? null:'checked');
                            alert('Nije updejtovano.');
                        });
            });

        });
    </script>
@endsection