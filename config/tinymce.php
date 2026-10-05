<?php

return [

	// 'cdn' => $app->runningInConsole() ? config('app.url') : url('vendor/js/tinymce/tinymce.min.js'),

	'cdn' => 'assets-admin/vendor/js/tinymce/tinymce.min.js',

	'default' => [
		"selector" => ".tinymce", 'height' => 300,
		"language" => 'en',
		"theme" => "modern",
		"skin" => "lightgray",
		"relative_urls" => false,
		"remove_script_host" => false,
		"plugins" => [
			"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
			"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			"save table contextmenu directionality emoticons template paste textcolor",
			"imageupload"
		],
		"toolbar" => "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | imageupload | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
	],
	// Custom
	
	/*'example' => [
		"selector" => "#example",
		"language" => 'pt_BR',
		"theme" => "modern",
		"skin" => "lightgray",
		"plugins" => [
	         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
	         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
	         "save table contextmenu directionality emoticons template paste textcolor"
		],
		"toolbar" => "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
	],*/

];
