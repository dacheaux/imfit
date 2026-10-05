<select class="form-control orderStatus" name="status"  data-id="{{ $orders->id }}">
    <option data-status="0" {{ $orders->status == '0' || $orders->status == ''? 'selected' : ''}} value="0">Neplaćeno</option>
    <option data-status="1" {{ $orders->status == '1' ? 'selected' : ''}} value="1">Plaćeno</option>
</select>
