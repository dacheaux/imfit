@if(!$userplans->active)
{!! Form::checkbox('active', $userplans->id,  $userplans->active) !!}
@else
    <i class="fa fa-check" aria-hidden="true" style="color: green;font-size: 18px;"></i>
@endif