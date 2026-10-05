{{--{{ QrCode::format('svg')->size(100)->generate($users->qrcode->token) }}--}}
{{--<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($users->qrcode->token)) !!} ">--}}
<img src="{{ asset('images/'.'qrcode'.$users->id.'.png') }}" width="200">
