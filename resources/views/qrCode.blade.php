<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<div class="visible-print text-center">
    <h1>{{ auth()->user()->name .' '.  auth()->user()->lastname  }}</h1>

  {{auth()->user()->role}}

    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate(url('/'.auth()->id()))) !!} ">


</div>

</body>
</html>
