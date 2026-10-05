@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.accountplans') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.accountplans') }}
@endsection

@section('style')
<style>

</style>
@endsection

@section('content')

    <div class="box box-primary">
         <div class="box-header">
            <a href="{{ route('admin.accountplans.create') }}" class="btn btn-primary btn-flat">
                  <i class="fa fa-plus"></i> &nbsp;&nbsp;
                {{ trans('admin_message.plans.create_plan') }}
            </a>
        </div>
        <div class="box-body">
           <table class="table table-striped table-bordered dt-responsive" id="plans-table" cellspacing="0" width="100%" role="grid">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('admin_message.plans.plan_name') }}</th>
                        <th>{{ trans('admin_message.plans.deposit_amount') }}</th>
                        <th>{{ trans('admin_message.plans.created') }}</th>
                        <th>{{ trans('admin_message.plans.inactive') }}</th>
                        <th>{{ trans('admin_message.plans.edit') }}</th>
                        <th>{{ trans('admin_message.plans.delete') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(function() {

            var table = $('#plans-table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: false,
                ordering: true,
                info: true,
                responsive: true,
                autoWidth: false,
                ajax: '{!! route('admin.accountplans.data') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'plan_name', name: 'plan_name'},
                    {data: 'deposit_amount', name: 'deposit_amount'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action2', name: 'action2', orderable: false, searchable: false},
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

            // Ajax
            $('body').on(  'change', ':checkbox',function() {

                $(this).hide().parent().append('<i class="fa fa-refresh fa-spin"></i>');

                var token = $('input[name="_token"]').val();
                var inactive = $(this).attr('name');

                if(inactive == 'inactive'){
                    $(this).parents('tr').toggleClass('danger').toggleClass('default');
                }
                $.ajax({
                    url: '/admin/updateaccountplans/' + this.value,
                    type: 'PUT',
                    data: inactive + "=" + this.checked + "&_token=" + token
                })
                    .done(function() {
                        $('.fa-spin').remove();
                        $('input[type="checkbox"]:hidden').show();
                        table.ajax.reload();
                    })
                    .fail(function() {
                        $('.fa-spin').remove();
                        var chk = $('input[type="checkbox"]:hidden');
                        if(inactive == 'inactive') {
                            chk.parents('tr').toggleClass('danger').toggleClass('default');
                        }
                        chk.show().prop('checked', chk.is(':checked') ? null:'checked');
                        alert('Nije updejtovano.');
                    });
            });

        });
    </script>
@endsection
