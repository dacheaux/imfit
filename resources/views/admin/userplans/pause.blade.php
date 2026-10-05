@if(!$userplans->pause_flag)
    Ne
@else
    @if($userplans->pause_from->toDateTimeString() !== '2000-01-01 00:00:00')
            {{ $userplans->pause_from->format('d.M.Y. H:i')  }}
    @else
        Ne
    @endif
@endif