<div style="display: inline-block" >
        <div class="custom-switch custom-switch-primary-inverse mb-2">
        {!! Form::checkbox('inactive', $products->id,  $products->inactive, ['class' => 'custom-switch-input', 'id' => 'swich'.$products->id ]) !!}
        <label class="custom-switch-btn" for="{{ 'swich'.$products->id  }}"></label>
    </div>
</div>

