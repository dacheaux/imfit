@extends('layouts.main')

@section('content')

<!-- breadcrumb section start -->
<div class="ff_bread_wrapper">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="ff_bread_box">
					<h1>PRETRAGA</h1>
					<ul class="pagination">
						<li><a href="{{ url('/') }}">Početna</a></li>
						<li><a href="{{ url('/treninzi') }}">Treninzi</a></li>
						<li>Pretraga: {{$term}}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- blog section start -->
<div class="ff_blog_wrapper top_padder80 bottom_padder30">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-12">

                @include('partials.blog-sidebar')

            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">

                    <div class="col-lg-12 col-md-12">
                        <div class="ff_heading">
                             <h3>Rezultati pretrage za "<span>{{$term}}</span>" ({!! ($posts != null)?$posts->total():0!!})</h3>
                        </div>
                    </div>

                    @foreach($posts as $post)

                        @include('posts.post')

                    @endforeach


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