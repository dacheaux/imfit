@extends('admin.layout')

@section('title')
	{{ trans('admin_message.dashboard') }}
@endsection

@section('heading')
	{{ trans('admin_message.dashboard') }}
   <span class="pull-right"> <div id="txt"></div></span>
@endsection

@section('content')
		<div class="row">


            @include('admin.partials._small-box',['color' => 'red', 'icon' => 'ion-ios-time', 'nbr' => $nbrUsersPlans, 'name' => trans('admin_message.sidebar.userplans').' - termini', 'href' => 'admin/userplans'])

            @include('admin.partials._small-box',['color' => 'green', 'icon' => 'ion-ios-calculator', 'nbr' => $nbrAccountUsersPlans, 'name' => trans('admin_message.sidebar.accountuserplans').' - računi', 'href' => 'admin/accountuserplans'])

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3 class="entrances-count">0</h3>
                        <p class="text-uppercase">Očitavanje QR koda</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-qrcode"></i>
                    </div>
                    <a href="{{url('admin/entrances')}}" class="small-box-footer">{{trans('admin_message.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            @include('admin.partials._small-box',['color' => 'yellow', 'icon' => 'ion-ios-people', 'nbr' => $nbrUsers, 'name' => trans('admin_message.sidebar.cusers'), 'href' => 'admin/users'])


		</div>


		<div>
			{!! $chart->container() !!}
		</div>
		<div class="row">



			<div class="col-lg-4 col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-birthday-cake"></i> Rođendani - {{ \Carbon\Carbon::now()->format('M') }}  </h3>
					</div>
					<div class="box-body">
						@if(count($birthData) > 0)
						<table class="table table-responsive">
							@foreach($birthData as $birth)
								@if( \Carbon\Carbon::parse($birth->birth)->format('d') >= \Carbon\Carbon::now()->format('d') )
								<tr>
									<td><a href="{{ url('admin/users/'.$birth->id.'/edit') }}">{{ $birth->name . ' ' .$birth->lastname }} </a> - {{ $birth->birth }}
										@if( \Carbon\Carbon::parse($birth->birth)->format('d') == \Carbon\Carbon::now()->format('d') )
											<span class="badge bg-red pull-right">Danas slavi rođendan. <i class="fa fa-birthday-cake"></i> <i class="fa  fa-bullhorn"></i> </span>
										@endif
									</td>
								</tr>
								@endif
							@endforeach
						@else
							<p>Nema više rođendana za ovaj mesec.</p>
						@endif
						</table>
					</div>

				</div>

			</div>

            <div class="col-lg-4 col-xs-12">
				<div class="box box-primary">
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

	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
	{!! $chart->script() !!}


@stop
