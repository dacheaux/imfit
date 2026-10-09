<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{trans('admin_message.photos.add')}}</h4>
      </div>
      <div class="modal-body">
            {!! html()->form('POST', route('admin.photos.store'))->acceptsFiles()->attributes(['id' => 'photo-form-add'])->open() !!}

            {!! html()->hidden('photoId', 1)->attributes(['id' => 'photoId']) !!}
            {!! html()->hidden('idphoto')->attributes(['id' => 'idphoto']) !!}

            <div class="form-group">
                {!! html()->label(trans('admin_message.photos.title'), 'title') !!}
                {!! html()->text('title')->attributes(['class' => 'form-control']) !!}
            </div>

           <div class="form-group">
                {!! html()->label(trans('admin_message.photos.description'), 'description') !!}
                {!! html()->text('description')->attributes(['class' => 'form-control']) !!}
            </div>

              <div class="form-group">
                {!! html()->label(trans('admin_message.photos.image'), 'path') !!}
                {!! html()->file('path')->attributes(['class' => 'file', 'data-preview-file-type' => 'text', 'accept' => 'image/*']) !!}
                <div id="path-messagge"></div>
              </div>
            <hr>

            {!! html()->submit(trans('admin_message.photos.save'))->attributes(['class' => 'btn btn-primary btn-flat', 'id' => 'photo-add']) !!}
            {{--<button type="button" class="btn btn-primary btn-flat" id="photo-add">{{ trans('admin_message.photos.create') }}</button>--}}
            <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">{{ trans('admin_message.photos.close') }}</button>
            {!! html()->form()->close() !!}
      </div>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
