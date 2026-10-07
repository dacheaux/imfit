<?php

namespace App\Http\Controllers;

use App\Account;
use App\Category;
use App\Door;
use App\Order;
use App\Product;
use App\Qrcode;
use App\User;
use Conner\Tagging\Model\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    protected $category, $product, $user, $qcode, $order, $account, $doors;

    public function __construct(Category $category, Door $doors, Product $product, User $user, Qrcode $qcode, Order $order, Account $account)
    {
        $this->category = $category;
        $this->product = $product;
        $this->user = $user;
        $this->qcode = $qcode;
        $this->order = $order;
        $this->account = $account;
        $this->doors = $doors;
        $this->middleware('auth');
    }

    public function index()
    {
        $qcode = $this->qcode->where('user_id', auth()->id())->firstOrfail();

        $token = $qcode->token;

        if(\request()->get('category_id') == 0){
            $products = $this->product->with('categories')->whereInactive(1)->orderBy('position')->latest()->paginate(12);
        }else{
            $cats = Category::where('id', \request()->get('category_id') )->firstOrFail();
            $products =  $this->product->with('categories')->where('category_id', $cats->id)->whereInactive(1)->orderBy('position')->paginate(12);
        }

        return view('shop.index', compact('products', 'token'));
    }

    public function payments()
    {
        $orders =  $this->order->with('products')->where('user_id', auth()->user()->id )->latest()->paginate(10);

        return view('shop.payments', compact('orders'));
    }

    public function order(Request $request)
    {

        if ($request->ajax()) {



            $door = $this->doors->findOrFail(1);

            if($door->door_state == 2 || $door->door_state == 3){
                return response(json_encode(['status' => false, 'message' => 'Trenutno se obavlja drugi proces, pokušajte ponovo.']));
            }

            $product = $this->product->where('product_quantity', '>', 0)->whereInactive(1)->find($request->get('product_id'));

            if($product == null){
                return response(json_encode(['status' => false, 'message' => 'Nema na stanju.']));
            }

            $account = $this->account->where('user_id', $request->get('user_id'))->first();

            if($account->balance < $request->get('order_amount')){
                return response(json_encode(['status' => false, 'message' => 'Nemate dovoljno sredstava na Vašem raučunu.']));
            }


            $this->order->create([
                'order_amount' => $request->get('order_amount'),
                'order_qty' => 1,
                'user_id' => $request->get('user_id'),
                'product_id' => $product->id,
                'status' => 1,
            ]);

            $door->fill(['door_state' => 2]);
            $door->touch();
            $door->save();

            $order = $this->order->where('user_id', $request->get('user_id'))->latest()->first();

            if($order->status == 1){
                $product->product_quantity = $product->product_quantity - 1;
                $product->save();
                $account->balance = $account->balance - $request->get('order_amount');
                $account->save();

                return response(json_encode(['status' => true]));
            }


            return response(json_encode(['status' => false,'message' => 'Došlo je do greške. Pokušajte ponovo.']));
        }
    }

}
