@extends('aptreneri.layout')

@section('title')
	{{ trans('admin_message.dashboard') }}
@endsection

@section('heading')
	{{ trans('admin_message.dashboard') }}
@endsection

@section('content')

		<div class="row">


			<div class="col-lg-4 col-xs-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<i class="fa fa-line-chart"></i>

						<h3 class="box-title">{{ trans('admin_message.currency_list') }}</h3>
					</div>
					<div class="box-body text-center">
						<iframe src="https://www.kursna-lista.info/resources/kursna-lista.php?format=4&br_decimala=4&promene=1&procenat=1"
							width="320px" height="220px" frameborder="0" scrolling="no"></iframe>
					</div>
				</div>
			</div>

            <div class="col-lg-4 col-xs-12">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(450)->generate($token)) !!} " class="img-responsive" style="margin-bottom: 20px;">
            </div>

		</div>

@endsection


@section('scripts')



@stop
