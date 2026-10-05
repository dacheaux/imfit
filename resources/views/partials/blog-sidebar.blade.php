<div class="ff_sidebar_wrapper">
    <div class="widget widget_search">
        {!! Form::open(['url'=>'treninzi/pretraga','method'=>'GET']) !!}
            <div class="input-group">
                <input class="form-control" type="search" name="q" placeholder="Pretraga" value="{{isset($term) ? $term : ''}}">
                <button class="search_btn"><i class="fa fa-search"></i></button>
            </div>
        {!! Form::close() !!}
    </div>
    <div class="widget widget_categories">
        <h4 class="widget-title">Таgovi</h4>
        <ul>
            @foreach($tags as $tag)
                <li><a href="{{ url('/treninzi/tag/'.$tag->slug) }}">{{ $tag->name }}<span>{{ $tag->count }}</span></a></li>
            @endforeach
        </ul>
    </div>
    <div class="widget widget_recent_posts">
        <h4 class="widget-title">Treninzi</h4>
        <ul>
            @foreach($posts as $post)
                <li>
                    @if($post->post_thumb != null)
                    <div class="recent_post_thumbnail">
                        <img src="{{ asset($post->post_thumb) }}"  alt="{{ $post->post_title }}" title="{{ $post->post_title }}">
                    </div>
                    @endif
                    <div class="recent_post_text">
                        <h5><a href="{{ url('treninzi/'.$post->slug)}}">{{ $post->post_title }}</a></h5>
                        <p><i class="fa fa-comments" aria-hidden="true"></i>{{ $post->commentCount() }} Komentara</p>
                    </div>
                </li>
            @endforeach

        </ul>
    </div>
    <div class="widget widget_social_icons">
        <h4 class="widget-title">Pratite nas</h4>
        <ul>
            <li><a href="https://www.facebook.com/imfit.sabac/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="https://www.instagram.com/imfit.sabac/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
        </ul>
    </div>
</div>
