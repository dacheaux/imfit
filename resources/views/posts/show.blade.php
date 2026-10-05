@extends('layouts.main')

@section('content')

<!-- breadcrumb section start -->
<div class="ff_bread_wrapper">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="ff_bread_box">
					<h1>{{ $post->post_title }}</h1>
					<ul class="pagination">
						<li><a href="{{ url('/') }}">Početna</a></li>
						<li><a href="{{ url('/treninzi') }}">Treninzi</a></li>
						<li>{{ $post->post_title }}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- blog section start -->
<div class="ff_blog_single_wrapper top_padder80 bottom_padder30">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">

                  @include('partials.blog-sidebar')

            </div>
            <div class="col-lg-8 col-md-12">
                <div class="ff_blog_all_items">
                    <div class="ff_blog_item">
                        @if($post->post_image != null)
                        <div class="ff_blog_single_img">
                            <img src="{{ asset($post->post_image) }}" alt="blog single" title="Blog Single" class="img-fluid">
                            <p><a href="{{ url('/treninzi/'.$post->slug) }}">{{ $post->created_at }}</a></p>
                        </div>
                        @endif
                        <div class="ff_blog_single_text">
                            <h4>{{ $post->post_title }}</h4>

                            <ul>
                                <li><i class="fa fa-comment" aria-hidden="true"></i>{{ $post->commentCount() }}</li>
                                <li><i class="fa fa-share-alt" aria-hidden="true"></i>Podeli
                                    @include('partials._socials2', ['url' => \Request::url().'/'.$post->slug])
                                </li>
                            </ul>

                            <p>{!! $post->post_body  !!} </p>

                            <div class="ff_tags">
                                <p><i class="fa fa-tags"></i>Tagovi -
                                    @foreach($post->tags as $tag)
                                        <a href="{{ url('/treninzi/tag/'.$tag->slug) }}" title="{{ $tag->name }}">{{ $tag->name }}</a>@if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
{{--                    <div class="ff_comments">--}}
{{--                        <h2>Komentari</h2>--}}
{{--                        <ul class="comment-list">--}}

{{--                            @foreach($post->comments as $comment)--}}

{{--                                       <li>--}}
{{--                                            <div class="ff_comment_box">--}}
{{--                                                    <div class="ff_comment_img">--}}
{{--                                                        <img src="{{ asset($comment->creator->avatar) }}" alt="{{ $comment->creator->name }}" title="{{ $comment->creator->name }}" class="img-fluid">--}}
{{--                                                    </div>--}}

{{--                                                <div class="ff_comment_text">--}}
{{--                                                    <h4><a href="#">{{ $comment->creator->name }}</a></h4>--}}
{{--                                                    <h5>{{ $comment->created_at }}<a href="#" class="reply_btn"><i class="fa fa-reply"></i>Odgovori</a></h5>--}}
{{--                                                    <p>{{  $comment->body  }}</p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                               <div class="ff_comment_form pt-3 reply-from">--}}

{{--                                                    @if(auth()->check())--}}
{{--                                                        <form action="{{ url('/treninzi/komentar/'.$post->id.'/odgovor/'.$comment->id) }}" method="POST">--}}
{{--                                                            {{ csrf_field() }}--}}
{{--                                                            <div class="row">--}}
{{--                                                                <div class="col-md-8 col-sm-12">--}}
{{--                                                                    <div class="ff_comment_input">--}}
{{--                                                                       <textarea  name="body"  placeholder="Tvoj odgovor..." class="form-control"></textarea>--}}
{{--                                                                        <button type="submit" class="ff_button pull-right" onclick="this.disabled=true;this.form.submit();" >Odgovori</button>--}}
{{--                                                                     </div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </form>--}}
{{--                                                    @else--}}
{{--                                                        <p class="text-center">Morate biti <a href="{{ route('login') }}"><span style="color: #bfd630;">prijavljeni</span></a>  da bi odgovorili na ovaj komentar.</p>--}}
{{--                                                    @endif--}}

{{--                                               </div>--}}
{{--                                        </li>--}}

{{--                                       @foreach($comment->children as $rep1)--}}

{{--                                                <li style="margin-left: 50px;">--}}
{{--                                                    <div class="ff_comment_box">--}}
{{--                                                            <div class="ff_comment_img">--}}
{{--                                                                <img src="{{ asset($rep1->creator->avatar) }}" alt="{{ $rep1->creator->name }}" title="{{ $rep1->creator->name }}" class="img-fluid">--}}
{{--                                                            </div>--}}

{{--                                                        <div class="ff_comment_text">--}}
{{--                                                            <h4><a href="#">{{ $rep1->creator->name }}</a></h4>--}}
{{--                                                            <h5>{{ $rep1->created_at }}<a href="#" class="reply_btn"><i class="fa fa-reply"></i>Odgovori</a></h5>--}}
{{--                                                            <p>{{  $rep1->body  }}</p>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                       <div class="ff_comment_form pt-3 reply-from">--}}

{{--                                                            @if(auth()->check())--}}
{{--                                                                <form action="{{ url('/treninzi/komentar/'.$post->id.'/odgovor/'.$comment->id) }}" method="POST">--}}
{{--                                                                    {{ csrf_field() }}--}}
{{--                                                                    <div class="row">--}}
{{--                                                                        <div class="col-md-8 col-sm-12">--}}
{{--                                                                            <div class="ff_comment_input">--}}
{{--                                                                               <textarea  name="body"  placeholder="Tvoj odgovor..." class="form-control"></textarea>--}}
{{--                                                                                <button type="submit" class="ff_button pull-right" onclick="this.disabled=true;this.form.submit();" >Odgovori</button>--}}
{{--                                                                             </div>--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                </form>--}}
{{--                                                            @else--}}
{{--                                                                <p class="text-center">Morate biti <a href="{{ route('login') }}"><span style="color: #bfd630;">prijavljeni</span></a>  da bi odgovorili na ovaj komentar.</p>--}}
{{--                                                            @endif--}}

{{--                                                       </div>--}}
{{--                                                </li>--}}

{{--                                        @endforeach--}}

{{--                            @endforeach--}}


{{--                        </ul>--}}
{{--                    </div>--}}

{{--                    <div class="ff_comment_form">--}}
{{--                        <h2>Ostavi komentar</h2>--}}

{{--                        @if(auth()->check())--}}
{{--                            <form action="{{ url('/treninzi/komentar/'.$post->id) }}" method="POST">--}}
{{--                                {{ csrf_field() }}--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-lg-12 col-md-12">--}}
{{--                                        <div class="ff_comment_input">--}}
{{--                                           <textarea name="body" placeholder="Tvoj komentar..." class="form-control"></textarea>--}}
{{--                                              <button type="submit" class="ff_button"  onclick="this.disabled=true;this.form.submit();" >Pošalji</button>--}}
{{--                                         </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        @else--}}
{{--                            <p>Morate biti <a href="{{ route('login') }}"><span style="color: #bfd630;">prijavljeni</span></a>  da bi ostavili komentar.</p>--}}
{{--                        @endif--}}

{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        (function () {
            $(".reply_btn").on('click', function (e) {
                e.preventDefault();
                $('.reply-from').hide();
                $(this).closest('li').children('.reply-from').toggle('show');
            });
        })();
    </script>
@endsection
