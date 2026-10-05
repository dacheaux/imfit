@foreach($posts->tagged as $tag)
<span class="tag label label-primary">{{ $tag->tag_name  }}</span>
@endforeach