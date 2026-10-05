@extends('layouts.main')

@section('content')

<!-- breadcrumb section start -->
@include('partials.breadcrumb', ['pageTitle' => 'treninzi'])

<!-- blog section start -->
<div class="ff_blog_wrapper top_padder80 bottom_padder30">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-12">

                @include('partials.blog-sidebar')

            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">

                @if(count($posts) > 0)

                @foreach($posts as $post)

                    <div class="col-lg-6 col-md-6">
                        <div class="ff_blog_box">
                            @if($post->post_thumb != null)
                                <div class="ff_blog_img">
                                    <img src="{{ asset($post->post_thumb) }}" alt="{{ $post->post_title }}" title="{{ $post->post_title }}" class="img-fluid">
                                    <p><a href="{{ url('treninzi/'.$post->slug) }}">{{ $post->created_at }}</a></p>
                                </div>
                            @endif
                            <div class="ff_blog_text">
                                <h2><a href="{{ url('treninzi/'.$post->slug) }}" title="{{ $post->post_title }}">{{ $post->post_title }}</a></h2>
                                <ul>
                                    <li><a href="{{ url('treninzi/'.$post->slug) }}"><i class="fa fa-comment" aria-hidden="true"></i>{{ $post->commentCount() }}</a></li>
                                    <li><a href="#"><i class="fa fa-share-alt" aria-hidden="true"></i>Podeli</a>
                                        @include('partials._socials2', ['url' => \Request::url().'/'.$post->slug])
                                    </li>
                                </ul>
                                <p>{{ $post->post_desc }}</p>
                                <a href="{{ url('treninzi/'.$post->slug) }}" class="ff_button">Pročitaj više</a>
                            </div>
                        </div>
                    </div>

                @endforeach

                @else

                    <div class="col-lg-12 col-md-12">
                        <div class="ff_heading">
                             <h3>Nema traženih rezultata.</h3>
                        </div>
                    </div>

                @endif


                    <div class="col-lg-12 col-md-12">
                        <div class="ff_pagination">
                            {{ $posts->links() }}
                        </div>
                    </div>



                </div>
            </div>
		</div>
	</div>
</div>

@endsection
