@if($photo->thumbnail_path != null)
<img src="{{ asset($photo->thumbnail_path) }}" alt="{{ $photo->title }}" class="attachment-img img-responsive" width="100">
@endif