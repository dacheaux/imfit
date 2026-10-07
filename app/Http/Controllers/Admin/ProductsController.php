<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{

    protected $products;

    public function __construct(Product $products)
    {
        $this->products = $products;

        parent::__construct();
    }

    public function index()
    {
        $categories = Category::with('categories')->where(['parent_id' => 0])->orderBy('sorting', 'ASC')->get();

        return view('admin.products.index', compact('categories'));
    }

    public function productsData(Request $request)
    {

        if( $request->get('category_id') === "Sve"){
            $products =  $this->products->with('categories')->orderBy('position')->get();
        }else{
            $cats = Category::where('id', $request->get('category_id'))->firstOrFail();
            $products =  $this->products->with('categories')->where('category_id', $cats->id)->orderBy('position')->get();
        }

        return DataTables::of($products)
            ->addColumn('image', function($product)  {
                return view('admin.products.image', compact('product'))->render();
            })
            ->addColumn('category', function($products) {
                return view('admin.products.category', compact('products'))->render();
            })
            ->addColumn('action', function($products) {
                return view('admin.products.action', compact('products'))->render();
            })
            ->addColumn('action0', function($products) {
                return view('admin.products.action0', compact('products'))->render();
            })
            ->addColumn('action1', function($products) {
                return view('admin.products.action1', compact('products'))->render();
            })
            ->addColumn('responsive', function ($products) {
                return view('admin.products.responsive', compact('products'))->render();
            })
            ->editColumn('order', '<i class="fa fa-arrows-alt" aria-hidden="true"></i>')
            ->rawColumns(['order','category','image','action','action0', 'action1', 'responsive'])
            ->make(true);

    }

    public function updateVisible(Request $request, $id){
        if($request->ajax()){
            $products = $this->products->findOrFail($id);
            if($request->get('inactive')){
                $products->inactive = $request->get('inactive') == 'true';
            }
            $products->save();

            return response()->json(['statut' => 'ok']);
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {

        $products = $this->products->findOrfail($id);

        $products->fill($request->only(
            'category_id',
            'product_name',
            'product_quantity',
            'product_description',
            'product_price'
        ));

        if($request->hasFile('product_image')) {

            $product_image = $request->file('product_image');
            $filename = time() . '.' . $product_image->getClientOriginalExtension();

            Image::make($product_image)->save(public_path('/uploads/products/' . $filename));

            if (\File::exists(public_path() . $products->product_image) && $products->product_image!=='/uploads/products/no-image.jpg') {
                \File::delete(public_path() . $products->product_image);
            }
            $products->product_image = '/uploads/products/'.$filename;
        }

        $products->save();

        flash()->success('Uspešno','Uspešno je izmenjen.');

        return redirect()->back();

    }

    public function create(Product $product)
    {

        $categories = Category::with('categories')->where(['parent_id' => 0])->orderBy('sorting', 'ASC')->get();

        return view('admin.products.form', compact('product', 'categories'));
    }


    public function store(StoreProductRequest $request){

        $poructCount =  $this->products->where('category_id', $request->get('category_id'))->count();

        $product = $this->products->fill(
            $request->only(
                'category_id',
                'product_name',
                'product_quantity',
                'product_description',
                'product_price'
            )
        );

        if($request->hasFile('product_image')) {

            $product_image = $request->file('product_image');
            $filename = time() . '.' . $product_image->getClientOriginalExtension();

            Image::make($product_image)->save(public_path('/uploads/products/' . $filename));

            if (\File::exists(public_path() . $product->product_image) && $product->product_image !== '/uploads/products/no-image.jpg') {
                \File::delete(public_path() . $product->product_image);
            }
            $product->product_image = '/uploads/products/'.$filename;
        }

        $product->position = $poructCount + 1;
        $product->save();

        flash()->success('Uspešno','Uspešno je dodat.');

        return redirect(route('admin.products.index'));
    }

    public function edit($id)
    {
        $product = $this->products->findOrFail($id);

        //$categories = $this->getParents();
        $categories = Category::with('categories')->where(['parent_id' => 0])->orderBy('sorting', 'ASC')->get();

        return view('admin.products.form', compact('product', 'categories'));
    }


    public function destroy($id)
    {
        $products = $this->products->findOrFail($id);

        if (\File::exists(public_path() . $products->product_image)  && $products->product_image!=='/uploads/products/no-image.jpg') {
            \File::delete(public_path() . $products->product_image);
            $products->product_image = '/uploads/products/no-image.jpg';
        }

        $products->delete();

        flash()->success('Uspešno','Uspešno je obrisan.');

        return redirect(route('admin.products.index'));
    }

    public function imageDelete(Request $request)
    {
        if($request->ajax()){
            $products = $this->products->findOrFail($request->get('product_id'));

            if (\File::exists(public_path() . $products->product_image) && $products->product_image !== '/uploads/products/no-image.jpg') {
                \File::delete(public_path() . $products->product_image);
                $products->product_image = '/uploads/products/no-image.jpg';
                $products->save();
            }
            return response('{}', 200);
        }

    }

    public function reorderData(Request $request)
    {
        $count = 0;

        if (count($request->json()->all())) {
            $ids = $request->json()->all();
            foreach($ids as $i => $key)
            {
                $id = $key['id'];
                $position = $key['position'];

                $products = $this->products->find($id);
                $products->position = $position;

                if($products->save())
                {
                    $count++;
                }
            }
            return response()->json(['statut' => 'ok']);
        }

    }


}
