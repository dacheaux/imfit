<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{trans('admin_message.photos.add')}}</h4>
      </div>
      <div class="modal-body">
            {!! Form::open([
                'method' => 'post',
                'route'  =>
                 'admin.photos.store',
                 'files' => true,
                 'id' => 'photo-form-add'
            ]) !!}

            {!! Form::hidden('photoId', 1,['id' =>'photoId']) !!}
            {!! Form::hidden('idphoto', null,['id' =>'idphoto']) !!}

            <div class="form-group">
                {!! Form::label('title', trans('admin_message.photos.title')) !!}
                {!! Form::text('title', null,['class' => 'form-control']) !!}
            </div>

           <div class="form-group">
                {!! Form::label('description', trans('admin_message.photos.description')) !!}
                {!! Form::text('description', null,['class' => 'form-control']) !!}
            </div>

              <div class="form-group">
                {!! Form::label('path', trans('admin_message.photos.image')) !!}
                {!! Form::file('path', ['class' => 'file', 'data-preview-file-type' => 'text', 'accept' => 'image/*']) !!}
                <div id="path-messagge"></div>
              </div>
            <hr>

            {!! Form::submit(trans('admin_message.photos.save'), ['class' => 'btn btn-primary btn-flat',  'id' => 'photo-add']) !!}
            {{--<button type="button" class="btn btn-primary btn-flat" id="photo-add">{{ trans('admin_message.photos.create') }}</button>--}}
            <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">{{ trans('admin_message.photos.close') }}</button>
            {!! Form::close() !!}
      </div>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
