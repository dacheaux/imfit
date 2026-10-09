@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.nposts') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.nposts') }}
@endsection

@section('style')
<link rel="stylesheet" href="{!! asset('assets-admin/css/fileinput.min.css') !!}" type="text/css" charset="utf-8" />
<link rel="stylesheet" href="{!! asset('assets-admin/css/bootstrap-tagsinput.css') !!}" type="text/css" charset="utf-8" />
@endsection

@section('content')

    <div class="box box-primary">
        <div class="box-header">
            <h3>{{$post->exists ? trans('admin_message.posts.edit_post') .' '.$post->post_title : trans('admin_message.posts.create_post')}}</h3>
        </div>
        <div class="box-body">
            {!! html()->modelForm($post, $post->exists ? 'put' : 'post', ($post->exists ? route('admin.posts.update', $post->id) : route('admin.posts.store')))->acceptsFiles()->open() !!}

            <div class="form-group">
                {!! html()->label(trans('admin_message.posts.post_title'), 'post_title') !!}
                {!! html()->text('post_title')->attributes(['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! html()->label(trans('admin_message.posts.slug'), 'slug') !!}
                {!! html()->text('slug')->attributes(['class' => 'form-control']) !!}
            </div>

             <div class="form-group">
                {!! html()->label(trans('admin_message.posts.post_desc'), 'post_desc') !!}
                {!! html()->text('post_desc')->attributes(['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                 {!! html()->label(trans('admin_message.posts.post_image'), 'post_image') !!}
                 {!! html()->file('post_image')->attributes(['class' => 'file', 'data-preview-file-type' => 'text', 'accept' => 'image/*']) !!}
            </div>

             <div class="form-group">
                {!! html()->label(trans('admin_message.posts.post_body'), 'post_body') !!}
                {!! html()->textarea('post_body')->attributes(['class' => 'form-control tinymce']) !!}
             </div>

            <div class="form-group">
                {!! html()->label(trans('admin_message.posts.tags'), 'posts_tags') !!}
                {{--{!! html()->text('posts_tags', $post->exists ? implode(',', $post->tagNames())  : null)->attributes(['class' => 'form-control', 'id' => 'postsTags', 'data-role' => 'tagsinput']) !!}--}}
                {!! html()->text('posts_tags', 'test')->attributes(['class' => 'form-control', 'id' => 'postsTags', 'data-role' => 'tagsinput']) !!}
            </div>

            <div class="checkbox">
                <label>
                    {!! html()->checkbox('active', null, 1)->forgetAttribute('id') !!}
                    <b>{!! trans('admin_message.posts.publish') !!}</b>
                </label>
            </div>

            {!! html()->submit($post->exists ? trans('admin_message.posts.save_post') : trans('admin_message.posts.create_post'))->attributes(['class' => 'btn btn-primary btn-flat']) !!}
            <a href="{!! url('admin/posts') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
           {!! html()->closeModelForm() !!}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{!! asset('assets-admin/js/fileinput.min.js') !!}"></script>
    <script src="{!! asset('assets-admin/js/fileinput_locale_sr.js') !!}"></script>
    <!-- Type aheaed -->
    <script src="{{ asset('assets-admin/js/typeahead.bundle.js') }}" type="text/javascript"></script>
    <!-- Bootstrap tags input -->
    <script src="{{asset('assets-admin/js/bootstrap-tagsinput.js')}}"></script>




    <script>
        $('input[name=post_title]').on('blur', function(){
           var slugElement = $('input[name=slug]');
            if(slugElement.val()){
                return;
            }
            slugElement.val(this.value.toLowerCase().replace(/[^a-z0-9-]+/g, '-').replace(/^-+|-+$/g, ''));
        });

        // initialize fileinputs
        $("#post_image").fileinput({
            language: "sr",
            showUpload: false,
            showCaption: false,
            allowedFileExtensions: ["jpg", "jpeg", "png", "gif"],
            previewFileType: "image",
            maxFileSize: 2000,
            browseLabel: 'Izaberi',
            @if($post->exists && $post->post_image != null)
            initialPreview: [
                '<img src="{!! asset($post->post_image) !!}" class="file-preview-image">'
            ],
            initialPreviewConfig: [
                {
                    url: "/admin/image-post",
                    extra: {
                        pos: 0,
                        _token: "{{ csrf_token() }}",
                        _method: "DELETE",
                        post_id: "{{$post->id}}"
                    }
                }
            ]
            @endif
        });
    </script>

    <script type="text/javascript" src="{{ asset(config('tinymce.cdn')) }}"></script>
    <script type="text/javascript">

        @if(isset($els))
            @foreach($els as $el)
                tinymce.init(
                    {!! json_encode(config('tinymce.'.$el)) !!}
                );
            @endforeach
        @else
            tinymce.init(
                {!! json_encode(config('tinymce.default')) !!}
            );
        @endif

    </script>
    <script>
        // Get the reference to the input field
        var tags = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '{!! url("/") !!}' + '/admin/posts_tags?keyword=%QUERY%',
                wildcard: '%QUERY%'
            },
            {{--prefetch: {--}}
                {{--cache: false,--}}
                {{--url: '{!! url("/") !!}' + '/admin/get_tags?id=' + '{!! $post->id !!}',--}}
            {{--}--}}
        });
        tags.initialize();

        var elt = $('#postsTags');

        elt.tagsinput({
            itemValue : 'name',
            itemText  : 'name',
            maxChars: 10,
            trimValue: true,
            allowDuplicates : false,
            freeInput: false,
            focusClass: 'form-control',
            tagClass: function(item) {
                    return 'label label-primary';
            },
            onTagExists: function(item, $tag) {
                $tag.hide().fadeIn();
            },
            typeaheadjs: {
                hint: false,
                highlight: true,
                name: 'tags',
                itemValue: 'name',
                displayKey: 'name',
                source: tags.ttAdapter(),
                templates: {
                    empty: [
                        '<ul class="list-group"><li class="list-group-item">Nema traženih tagova.</li></ul>'
                    ],
                    header: [
                        '<ul class="list-group">'
                    ],
                    suggestion: function (data) {
                        return '<li class="list-group-item">' + data.name + '</li>'
                    }
                }
            }
        });


        $.getJSON(  '{!! url("/") !!}' + '/admin/get_tags?id=' + '{!! $post->id !!}', {
            format: "json"
        })
        .done(function( data ) {
            $.each( data, function( i, item ) {
                elt.tagsinput('add', { "id": item.id, "name": item.tag_name, "slug": item.tag_slug });
            });
        });




    </script>
@stop