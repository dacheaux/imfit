<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ControllerCustom extends Controller
{

    public function imageUpload(Request $request) {
        $file = $request->file('imagefile');
        $fname = str_random(10).$file->getClientOriginalName();
        $file->move('upload-posts', $fname);
        $file_path = url('upload-posts').'/'.$fname;

        return view('admin._image-upload', compact('file_path'));
    }
}
