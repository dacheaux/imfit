<div class="ff_sidebar_wrapper">
    <div class="widget widget_categories">
        {{ Form::open(['method' => 'GET']) }}

        <div class="form-group">
            <div class="col-md-4">
                <label for="category_id">Kategorije:</label>
                <select name="category_id" id="category_id" onchange="this.form.submit()" class="form-control" style="width: 100%;">
                    <option value="0">Sve</option>
                    @foreach($categories as $cat)
                        @if(count($cat->categories) > 0 )
                            <option value="{{ $cat->id }}" class="opt-disabled" disabled="disabled" >{{ $cat->category_name }}</option>
                            @foreach($cat->categories as $sub_category )
                                <option value="{{ $sub_category->id }}" {{ request()->get('category_id') == $sub_category->id  ? 'selected' : ''  }}>--{{ $sub_category->category_name }}</option>
                            @endforeach
                        @else
                            @if($cat->parent_id == 0)
                            <option value="{{ $cat->id }}" {{ request()->get('category_id') == $cat->id  ? 'selected' : ''  }}>{{ $cat->category_name }}</option>
                            @endif
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        {{ Form::close() }}
    </div>
</div>
