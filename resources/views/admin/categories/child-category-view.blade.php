@if(!empty($category->categories))
    <ol class="dd-list list-group">
        @foreach($category->categories as $kk => $sub_category)
            <li class="dd-item list-group-item" data-id="{{ $sub_category['id'] }}" >
                <div class="dd-handle" >{{ $sub_category['category_name'] }}</div>
                <div class="dd-option-handle">
                    <a href="{{ route('admin.categories.edit', ['id' => $sub_category['id'] ]) }}" class="btn btn-success btn-sm" >Izmeni</a>
                    <a href="{{ route('admin.categories.remove', ['id' => $sub_category['id'] ]) }}" class="btn btn-danger btn-sm" >Obriši</a>
                </div>

                @include('admin.categories.child-category-view', [ 'category' => $sub_category])
            </li>
        @endforeach
    </ol>
@endif
