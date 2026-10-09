@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.membership') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.membership') }}
@endsection

@section('content')

    <div class="col-md-4">
        <div class="box box-primary">



            <div class="box-header">
                <h3>{{$membership->exists ? trans('admin_message.membership.edit').' FA - '.$membership->user->id .' : '.$membership->user->name . ' '.$membership->user->lastname : trans('admin_message.membership.create')}}</h3>
            </div>

            <div class="box-body">

                {!! html()->modelForm($membership, $membership->exists ? 'put' : 'post', ($membership->exists ? route('admin.memberships.update', $membership->id) : route('admin.memberships.store')))->acceptsFiles()->attributes(['id' => 'membership-form'])->open() !!}
                <div class="col-md-12">

                    @if(!$membership->exists)
                        <div class="form-group">
                             <label for="channel_id">{{ trans('admin_message.membership.user') }}:</label>
                             <select name="user_id" id="user_id" class="form-control" required>
                                     @foreach($users as $user)
                                         <option value="{{ $user->id }}" {{  $membership->exists &&  $membership->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }} {{ $user->lastname }}</option>
                                     @endforeach
                             </select>
                        </div>
                    @endif

                    <div class="form-group">
                        {!! html()->label(trans('admin_message.membership.terms_number').'*', 'terms_number') !!}
                        {!! html()->number('terms_number')->attributes(['class' => 'form-control', 'min' => 0]) !!}
                    </div>

                    <div class="form-group">
                        {!! html()->label(trans('admin_message.membership.expired_time'), 'expired_time') !!}
                        {!! html()->date('expired_time', $membership->exists ?  \Carbon\Carbon::parse($membership->expired_time):  \Carbon\Carbon::now())->attributes(['class' => 'form-control']) !!}
                    </div>

                    <div class="pull-right">
                       {!! html()->submit($membership->exists ? trans('admin_message.users.save') : trans('admin_message.membership.create'))->attributes(['class' => 'btn btn-primary btn-flat']) !!}
                        <a href="{!! url('admin/memberships') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
                        {!! html()->closeModelForm() !!}
                    </div>

                </div>
                <br>
              <p>* Prilikom izmene članarine, korisniku resetujemo pauzu od 7 dana.</p>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>

@endsection
