<?php

namespace App\Http\Controllers\Admin;

use App\GlobalConf;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GlobalConfController extends Controller
{
        protected $globalConf;

    public function __construct(GlobalConf $globalConf)
    {
        $this->globalConf = $globalConf;

        parent::__construct();
    }


    public function index()
    {
       $globalConf = $this->globalConf->findOrfail(1);

       return view('admin.global.index', compact('globalConf'));
    }


    public function update(Request $request, $id, Factory $cache)
    {
        $globalConf = $this->globalConf->findOrfail(1);

           $validator = Validator::make($request->all(), [
            'time_book' => 'required|numeric',
            'time_delay' => 'required|numeric',
            'time_pause' => 'required|numeric',
        ]);

        if (!$validator->fails()) {

            $globalConf->fill($request->only('time_book', 'time_delay', 'time_pause'))->save();

            flash()->overlay(trans('flash.success'), trans('flash.global.supdated'));

            $cache->forget('settings');

            return redirect()->back();
        }

         return redirect()->back()->withInput()->withErrors($validator->errors());
    }

}
