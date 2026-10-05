@foreach($users->getRoleNames() as $name)
    @if($name == 'admin')
    <span class="tag label label-danger">{{ $name  }}</span>
    @elseif($name == 'trener')
    <span class="tag label label-info">{{ $name  }}</span>
    @else
        <span class="tag label label-primary">{{ $name  }}</span>
    @endif
@endforeach