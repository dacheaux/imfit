<!doctype html>
<html lang="sr">
<head>
    <title>{{ $picture->title  }} - I'am Fit</title>
   	<meta charset="utf-8">
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="description" content="{{ $picture->description  }}" />
    <meta content="website" property="og:type" />
    <meta property="og:title" content="{{ $picture->title  }}">
    <meta property="og:description" content="{{ $picture->description  }}">
    <meta property="og:type" content="product">
    <meta property="og:url" content="{{ $picture->path }}">

    </head>
<body>

 <img src="{{ asset($picture->path) }}" alt="{{ $picture->title  }}">
</body>
</html>
