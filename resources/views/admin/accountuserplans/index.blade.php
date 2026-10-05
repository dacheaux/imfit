@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.accountuserplans') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.accountuserplans') }}
@endsection

@section('style')
<style>

</style>
@endsection

@section('content')

    <div class="box box-primary">
        <div class="box-header">
            <a href="{{ route('admin.accountuserplans.create') }}" class="btn btn-primary btn-flat">
                <i class="fa fa-plus-circle"></i> &nbsp;&nbsp;
                {{ trans('admin_message.accountuserplans.create_userplan') }}
            </a>
            <hr>
        </div>
        <div class="box-body">
           <table class="table table-striped table-bordered dt-responsive" id="userplans-table" cellspacing="0" width="100%" role="grid">
                <thead>
                    <tr>
                        <th>Br. por.#</th>
                        <th>{{ trans('admin_message.users.name') }}</th>
                        <th>{{ trans('admin_message.users.lastname') }}</th>
                        <th>{{ trans('admin_message.accountuserplans.plan_name') }}</th>
                        <th>{{ trans('admin_message.accountuserplans.deposit_amount') }}</th>
                        <th>{{ trans('admin_message.accountuserplans.created') }}</th>
                        <th>{{ trans('admin_message.accountuserplans.approved') }}</th>
                        <th>{{ trans('admin_message.accountuserplans.paid') }}</th>
                        <th>{{ trans('admin_message.accountuserplans.delete') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(function() {

            $('#plan_id').change(function(e) {
                table.draw();
                e.preventDefault();
            });

            $('#expired_time').change(function(e) {
                table.draw();
                e.preventDefault();
            });

            var table = $('#userplans-table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: false,
                ordering: true,
                info: true,
                responsive: true,
                autoWidth: false,
                ajax:  {
                    url: '{!! route('admin.accountuserplans.data') !!}',
                    data: function (d) {
                        d.plan_id = $('#plan_id').val();
                        d.expired_time = $('#expired_time').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'user.lastname', name: 'user.lastname'},
                    {data: 'accountplan.plan_name', name: 'accountplan.plan_name'},
                    {data: 'accountplan.deposit_amount', name: 'accountplan.deposit_amount'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'approved', name: 'approved', orderable: false, searchable: false},
                    {data: 'paid', name: 'paid', orderable: false, searchable: false},
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
                var checkbox = $(this).attr('name');

                if(checkbox == 'approved' || checkbox == 'paid' ){
                    $(this).parents('tr').toggleClass('danger').toggleClass('default');
                }
                $.ajax({
                    url: '/admin/updateAccountPlan/' + this.value,
                    type: 'PUT',
                    data: checkbox + "=" + this.checked + "&_token=" + token
                })
                    .done(function(msg) {
                        $('.fa-spin').remove();
                        $('input[type="checkbox"]:hidden').show();
                        table.ajax.reload();
                        if(msg.statut !== 'ok'){
                            alert(msg.statut)
                        }
                    })
                    .fail(function() {
                        $('.fa-spin').remove();
                        var chk = $('input[type="checkbox"]:hidden');
                        if(checkbox == 'approved' || checkbox == 'paid' || checkbox == 'active' || checkbox == 'pause_flag') {
                            chk.parents('tr').toggleClass('danger').toggleClass('default');
                        }
                        chk.show().prop('checked', chk.is(':checked') ? null:'checked');
                        alert('Nije uspelo, pokusaj opet.');
                    });
            });

        });
    </script>
@endsection
