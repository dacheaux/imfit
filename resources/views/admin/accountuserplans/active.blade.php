@if(!$accountuserplans->active)
{!! Form::checkbox('active', $accountuserplans->id,  $accountuserplans->active) !!}
@else
    <i class="fa fa-check" aria-hidden="true" style="color: green;font-size: 18px;"></i>
@endif
