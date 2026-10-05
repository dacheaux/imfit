@if($data['payment_status'] == 0)
    <span class="label label-success">Plaćen</span>
@else
    <span class="label label-danger">Neplaćen</span>
@endif
