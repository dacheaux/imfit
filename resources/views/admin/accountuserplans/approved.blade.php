@if(!$accountuserplans->approved)
{!! Form::checkbox('approved', $accountuserplans->id,  $accountuserplans->approved) !!}
@else
    <i class="fa fa-check" aria-hidden="true" style="color: green;font-size: 18px;"></i>
@endif
