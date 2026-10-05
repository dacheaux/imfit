@if(!$accountuserplans->paid)
{!! Form::checkbox('paid', $accountuserplans->id,  $accountuserplans->paid) !!}
@else
    <i class="fa fa-check" aria-hidden="true" style="color: green;font-size: 18px;"></i>
@endif
