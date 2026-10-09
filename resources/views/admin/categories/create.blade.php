@extends('admin.layout')

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h1 class="page-header">Dodaj Kategoriju</h1>
        </div>
        <div class="box-body">

            <div class="col-md-6">

            {!! html()->form('POST', route('admin.categories.store'))->open() !!}

                @if(isset($category['id']))
                    <input type="hidden" name="id" value="{{ $category['id'] }}" >
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Naziv kategorije</label>
                        <input type="text" name="category_name" class="form-control" value="{{ (isset($category['category_name']))? $category['category_name'] : '' }}" >
                        @if($errors->first('category_name'))
                            <label for="" style="color:red;">{{ $errors->first('category_name') }}</label>
                        @endif
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-6">
                        <label for="">Parent ID (podkategorija)</label>
                        <select name="parent_id" class="form-control">
                            <option value="">## Glavna kategorija ##</option>
                            @foreach($categories as $k => $v)
                                @if($v['parent_id'] == 0)
                                <option value="{{ $v['id'] }}" {{ (isset($category['parent_id']) && $category['parent_id'] == $v['id'])? 'selected="selected"' : '' }} >{{ $v['category_name'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-success" value="Sačuvaj">
                    </div>
                </div>

            {!! html()->form()->close() !!}
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>

    </script>
@endsection
