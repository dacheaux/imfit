@if(!$userplans->approved)
{!! Form::checkbox('approved', $userplans->id,  $userplans->approved) !!}
@else
    <i class="fa fa-check" aria-hidden="true" style="color: green;font-size: 18px;"></i>
@endif