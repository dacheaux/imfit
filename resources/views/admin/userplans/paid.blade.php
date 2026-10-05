@if(!$userplans->paid)
{!! Form::checkbox('paid', $userplans->id,  $userplans->paid) !!}
@else
    <i class="fa fa-check" aria-hidden="true" style="color: green;font-size: 18px;"></i>
@endif