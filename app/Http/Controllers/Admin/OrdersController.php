<?php

namespace App\Http\Controllers\Admin;

//use App\Mail\SendOrderMail;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class OrdersController extends Controller
{

    public function index()
    {
        return view('admin.orders.index');
    }

    public function ordersData()
    {
        $orders = Order::with('products')->with('user')->latest();

        return DataTables::of($orders)
            ->addColumn('status', function($orders) {
                return view('admin.orders.status', compact('orders'))->render();
            })
            ->addColumn('action0', function($orders) {
                return view('admin.orders.action0', compact('orders'))->render();
            })
            ->addColumn('action1', function($orders) {
                return view('admin.orders.action1', compact('orders'))->render();
            })
            ->addColumn('views', function($orders) {
                return view('admin.orders.views', compact('orders'))->render();
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['status','action','action0', 'action1', 'views'])
            ->make();
    }

    public function update(Request $request, $id)
    {
        if($request->ajax()){
            $orders = Order::findOrFail($id);

            if($request->get('status') || $request->get('status') ==  "0"){
                $orders->status = $request->get('status');
            }
            $orders->save();

            return response()->json(['status' => $request->get('status')]);
        }
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        return response()->json(['success' => true], 200);
    }
}
