@if(!$accountuserplans->paid)
{!! html()->checkbox('paid', $accountuserplans->paid, $accountuserplans->id)->forgetAttribute('id') !!}
@else
    <i class="fa fa-check" aria-hidden="true" style="color: green;font-size: 18px;"></i>
@endif
