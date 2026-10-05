@extends('layouts.main')

@section('content')
<!-- breadcrumb section start -->
@include('partials.breadcrumb', ['pageTitle' => 'galerija'])
<!-- gallery section start -->
<div class="ff_gallery_wrapper top_padder80 bottom_padder50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="ff_heading">
                    <h1><span>Naša</span> galerija</h1>
                </div>
            </div>
            @if($photos->count() > 0)
                 @foreach($photos as $photo)
                    <div class="col-lg-3 col-xs-6 col-md-5">
                        <div class="ff_gallery_box">
                            <img src="{{ asset($photo->thumbnail_path) }}" alt="{{ $photo->title  }}"  title="{{ $photo->title  }}"  class="img-fluid">
                            <div class="ff_gallery_overlay popup-gallery">
                                <a href="{{ asset($photo->path) }}" title="{{ $photo->title  }}" data-link="{{ url('/slika/'.$photo->id.'/'.$photo->title) }}"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                    </div>
                 @endforeach
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>

    </script>
@endsection