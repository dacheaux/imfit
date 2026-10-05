@extends('admin.layout')


@section('title', 'Proizvod')

@section('style')
<link rel="stylesheet" href="{{ asset('assets-admin/css/fileinput.min.css') }}" type="text/css" charset="utf-8" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
<style>
    .select2-selection__rendered {
        line-height: 31px !important;
        border-radius: 0;
    }
    .select2-container .select2-selection--single {
        height: 35px !important;
        border-radius: 0;
    }
    .select2-selection__arrow {
        height: 34px !important;
        border-radius: 0;
    }
    .select2-container--default .select2-results__option[aria-disabled=true] {
        color: #999;
        background-color: #eee;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: #000;
    }
</style>
@endsection

@section('content')


        <div class="col-md-6">
            <div class="box box-primary ">
                <div class="box-header">
                    <h3>{{$product->exists ?  'Izmena proizvoda:'.' '.$product->title :  'Dodavanje proizvoda'}}</h3>
                </div>
                <div class="box-body">
                    {{ Form::model($product, [
                        'files' => true,
                        'method' => $product->exists ? 'put' : 'post',
                        'route'  => $product->exists ?
                         ['admin.products.update', $product->id]:
                         ['admin.products.store']
                    ]) }}

                    <div class="form-group">
                        <span class="help-block">(*776x860)</span>
                        {{ Form::label('product_image', 'Slika proizvoda') }}
                        {{ Form::file('product_image', ['class' => 'file', 'data-preview-file-type' => 'text', 'accept' => 'image/*']) }}
                    </div>

                    <div class="form-group">
                        <label for="category_id">Izaberi kategoriju:</label>
                        <select name="category_id" id="category_id" class="form-control" style="width: 100%;">
                            <option value="Sve">Sve</option>
                            @foreach($categories as $cat)
                                @if(count($cat->categories) > 0 )
                                    <option value="{{ $cat->id }}" class="opt-disabled" disabled="disabled" >{{ $cat->category_name}}</option>
                                    @foreach($cat->categories as $sub_category )
                                        <option value="{{ $sub_category->id }}" {{ $product->exists && $sub_category->id == $product->category_id  ? "selected" : ''  }}>-{{ $sub_category->category_name}}</option>
                                    @endforeach
                                @else
                                    <option value="{{ $cat->id }}" class="opt-disabled" {{ $product->exists && $cat->id == $product->category_id  ? "selected" : ''  }} >{{ $cat->category_name}}</option>
                                @endif
                            @endforeach
                        </select>
                        {!! Form::hidden('category_id', $product->exists ? $product->category_id : 1, ['id' => 'categoryId']) !!}
                    </div>

                    <div class="form-group">
                        {{ Form::label('product_name', 'Naziv') }}
                        {{ Form::text('product_name', null,['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('product_price', 'Cena') }}
                        {{ Form::text('product_price', null,['class' => 'form-control']) }}

                    </div>
                    <div class="form-group">
                        {{ Form::label('product_quantity', 'Količina') }}
                        {{ Form::text('product_quantity', null,['class' => 'form-control']) }}

                    </div>

                    <div class="form-group">
                        {{ Form::label('product_description', 'Opis') }}
                        {{ Form::textarea('product_description', null,['class' => 'form-control', 'id' => 'editor2']) }}
                    </div>

                    {{ Form::submit($product->exists ? 'Sačuvaj izmene': 'Kreiraj proizvod', ['class' => 'btn btn-primary btn-flat']) }}
                    <a href="{{ url('admin/products') }}" title="Odustani" class="btn btn-danger btn-flat">Odustani</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        var configShared = {
                startupOutlineBlocks:true,
                scayt_autoStartup:true,
                // etc.
            },

            config2 = CKEDITOR.tools.prototypedCopy(configShared);

        config2.height = 200;


        CKEDITOR.replace('editor2', config2);

    </script>
    <script src="{{ asset('assets-admin/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets-admin/js/fileinput_locale_sr.js') }}"></script>

    <script>
        $('#category_id').select2();

        function setSelectValue(id, val) {
            $(id).val(val);
        }

        $('#category_id').change(function(e) {
            setSelectValue('#categoryId', this.value);
            setSelectValue('#category_id', this.value);
            e.preventDefault();
        });

        $('input[name=title]').on('blur', function(){
           var slugElement = $('input[name=slug]');
            if(slugElement.val()){
                return;
            }
            slugElement.val(this.value.toLowerCase().replace(/[^a-z0-9-]+/g, '-').replace(/^-+|-+$/g, ''));
        });

        // initialize fileinputs
        $("#product_image").fileinput({
            language: "sr",
            showUpload: false,
            showCaption: false,
            allowedFileExtensions: ["jpg", "jpeg", "png", "gif"],
            previewFileType: "image",
            maxFileSize: 2000,
            browseLabel: 'Izaberi',
            @if($product->exists && $product->product_image !== '/uploads/products/no-image.jpg'  && $product->product_image !== null)
            initialPreview: [
                '<img src="{{ asset($product->product_image) }}" class="file-preview-image">'
            ],
            initialPreviewConfig: [
                {
                    url: "/admin/image-product",
                    extra: {
                         pos: 0,
                        _token: "{{ csrf_token() }}",
                        _method: "DELETE",
                        product_id: "{{$product->id}}"
                    }
                }
            ]
            @endif
        });
    </script>

{{--    <script type="text/javascript" src="{{ asset(config('tinymce.cdn')) }}"></script>--}}
{{--    <script type="text/javascript">--}}

{{--        @if(isset($els))--}}
{{--            @foreach($els as $el)--}}
{{--                tinymce.init(--}}
{{--                    {{ json_encode(config('tinymce.'.$el)) }}--}}
{{--                );--}}
{{--            @endforeach--}}
{{--        @else--}}
{{--            tinymce.init(--}}
{{--                {{ json_encode(config('tinymce.default')) }}--}}
{{--            );--}}
{{--        @endif--}}

{{--    </script>--}}
@stop
