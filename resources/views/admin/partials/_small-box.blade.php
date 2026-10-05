<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-{{ $color }}">
        <div class="inner">
            <h3>{{ $nbr }}</h3>

            <p class="text-uppercase">{{ $name }}</p>
        </div>
        <div class="icon">
            <i class="ion {{ $icon }}"></i>
        </div>
        <a href="{{url($href)}}" class="small-box-footer">{{trans('admin_message.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
