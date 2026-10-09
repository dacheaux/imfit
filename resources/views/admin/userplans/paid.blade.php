@if(!$userplans->paid)
{!! html()->checkbox('paid', $userplans->paid, $userplans->id)->forgetAttribute('id') !!}
@else
    <i class="fa fa-check" aria-hidden="true" style="color: green;font-size: 18px;"></i>
@endif