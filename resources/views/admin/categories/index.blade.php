@extends('admin.layout')

@section('style')
    <link rel="stylesheet" href="{{ url('assets-admin/css/categories.css') }}">
@endsection

@section('content')

    <div class="box box-primary">
        <div class="box-header">
            <h1 class="page-header">Sve Kategorije</h1>
        </div>
        <div class="box-body">

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <a class="btn btn-primary" href="{{ route('admin.categories.create') }}"><i class="fa fa-plus"></i> Dodaj Kategoriju</a>

            <hr>
                <div class="col-md-12 dd" id="nestable-wrapper">
                    <ol class="dd-list list-group">
                        @foreach($categories as $k => $category)
                            <li class="dd-item list-group-item" data-id="{{ $category['id'] }}" >
                                <div class="dd-handle" >{{ $category['category_name'] }}</div>
                                <div class="dd-option-handle">
                                    <a href="{{ route('admin.categories.edit', ['id' => $category['id'] ]) }}" class="btn btn-success btn-sm" >Izmeni</a>
                                    <a href="{{ route('admin.categories.remove', ['id' => $category['id'] ]) }}" class="btn btn-danger btn-sm" >Obriši</a>
                                </div>

                                @if(!empty($category->categories))
                                    @include('admin.categories.child-category-view', [ 'category' => $category])
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>

                <div class="clearfix"></div>

                <hr>

                {!! Form::open(['route' => ['admin.categories.save-nested-categories'], 'method' => 'POST']) !!}
                    <textarea style="display: none;" name="nested_category_array" id="nestable-output"></textarea>
                    <button type="submit" class="btn btn-success" style="margin-top: 15px;" >Sačuvaj izmene</button>
                {!! Form::close() !!}


                <hr>

        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ url('assets-admin/js/jquery.nestable.js') }}"></script>
    <script>
        $(document).ready(function()
        {

            var updateOutput = function(e)
            {
                var list   = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };

            // activate Nestable for list 1
            $('#nestable-wrapper').nestable({
                group: 1,
                maxDepth : 2,
            })
                .on('change', updateOutput);

            // output initial serialised data
            updateOutput($('#nestable-wrapper').data('output', $('#nestable-output')));

            $('#nestable-menu').on('click', function(e)
            {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });


        });
    </script>
@endsection
