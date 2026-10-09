@if($users->qrcode)
<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($users->qrcode->token)) !!} " width="200">
@else
--
@endif
