@if(!$userplans->approved)
{!! html()->checkbox('approved', $userplans->approved, $userplans->id)->forgetAttribute('id') !!}
@else
    <i class="fa fa-check" aria-hidden="true" style="color: green;font-size: 18px;"></i>
@endif