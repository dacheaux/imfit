<div class="col-lg-6 col-md-6">
    <div class="ff_blog_box">
        @if($post->post_thumb != null)
        <div class="ff_blog_img">
            <img src="{{ asset($post->post_thumb) }}" alt="{{ $post->post_title }}" title="{{ $post->post_title }}" class="img-fluid">
            <p><a href="{{ url('blog/'.$post->slug) }}">{{ $post->created_at }}</a></p>
        </div>
        @endif
        <div class="ff_blog_text">
            <h2><a href="{{ url('blog/'.$post->slug) }}" title="{{ $post->post_title }}">{{ $post->post_title }}</a></h2>
            <ul>
                <li><a href="{{ url('blog/'.$post->slug) }}"><i class="fa fa-comment" aria-hidden="true"></i>26</a></li>
                <li><a href="#"><i class="fa fa-share-alt" aria-hidden="true"></i>Podeli</a>
                    @include('partials._socials2', ['url' => \Request::url().'/'.$post->slug])
                </li>
            </ul>
            <p>{{ $post->post_desc }}</p>
            <a href="{{ url('blog/'.$post->slug) }}" class="ff_button">Pročitaj više</a>
        </div>
    </div>
</div>