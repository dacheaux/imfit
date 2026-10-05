<?php

namespace App\Http\Controllers\Api\Admin;


use App\Entry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EntryApiController extends Controller
{
    public function getEntrances(Request  $request)
    {
        return Entry::whereSeen(false)->latest()->count();

    }
}
