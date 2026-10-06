<?php

namespace App\Http\Controllers\admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index(Request $request){
        $info = [
            'categories' => Category::where(['parent_id' => 0])->orderBy('sorting', 'ASC')->get(),
        ];

        return view('admin.categories.index', $info);
    }

    public function saveNestedCategories(Request $request){

        $json = $request->nested_category_array;
        $decoded_json = json_decode($json, TRUE);

        $simplified_list = [];
        $this->recur1($decoded_json, $simplified_list);

        DB::beginTransaction();
        try {
            $info = [
                "success" => FALSE,
            ];

            foreach($simplified_list as $k => $v){
                $category = Category::find($v['id']);
                $category->fill([
                    "parent_id" => $v['parent_id'],
                    "sorting" => $v['sorting'],
                ]);

                $category->save();
            }

            DB::commit();
            $info['success'] = TRUE;
        } catch (\Exception $e) {
            DB::rollback();
            $info['success'] = FALSE;
        }

        if($info['success']){
            $request->session()->flash('success', "Kategorije  uspešno ažurirane.");
        }else{
            $request->session()->flash('error', "Došlo je do greške...");
        }

        return redirect(route('admin.categories.index'));
    }

    public function recur1($nested_array=[], &$simplified_list=[]){

        static $counter = 0;

        foreach($nested_array as $k => $v){

            $sorting = $k+1;
            $simplified_list[] = [
                "id" => $v['id'],
                "parent_id" => 0,
                "sorting" => $sorting
            ];

            if(!empty($v["children"])){
                $counter+=1;
                $this->recur2($v['children'], $simplified_list, $v['id']);
            }

        }
    }

    public function recur2($sub_nested_array=[], &$simplified_list=[], $parent_id = NULL){

        static $counter = 0;

        foreach($sub_nested_array as $k => $v){

            $sorting = $k+1;
            $simplified_list[] = [
                "id" => $v['id'],
                "parent_id" => $parent_id,
                "sorting" => $sorting
            ];

            if(!empty($v["children"])){
                $counter+=1;
                return $this->recur2($v['children'], $simplified_list, $v['id']);
            }
        }
    }

    public function create(Request $request){
        $info = [
            'categories' => Category::orderBy('category_name', 'ASC')->get(),
        ];

        return view('admin.categories.create', $info);
    }

    public function store(Request $request){
        $rules=[
            'category_name' => 'required',
        ];

        $messages = [
            "category_name.required" => "Naziv kategorije je obavezan."
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if( $validator->fails() ){
            return back()->withErrors($validator)->withInput();
        } else {
            DB::beginTransaction();
            try {
                $info = [
                    "success" => FALSE,
                ];
                $query = [
                    'category_name' => $request->category_name,
                    'category_slug' => Str::slug($request->category_name),
                    'parent_id' => (!empty($request->parent_id))? $request->parent_id : 0,
                    'visible' => 1
                ];

                $category = Category::updateOrCreate(['id' => $request->id], $query);

                DB::commit();
                $info['success'] = TRUE;
            } catch (\Exception $e) {
                DB::rollback();
                $info['success'] = FALSE;
            }

            if(!$info['success']){
                return redirect(route('admin.categories.index'))->with('error', "Greška prilikom kreiranja.");
            }

            return redirect(route('admin.categories.index'))->with('success', "Uspešno sačuvano.");
        }
    }

    public function edit(Request $request){
        $info = [
            'categories' => Category::orderBy('category_name', 'ASC')->get(),
            'category' => Category::find($request->id),
        ];

        return view('admin.categories.create', $info);
    }

    public function remove(Request $request){
        $category = Category::find($request->id);
        $category->delete();

        return redirect(route('admin.categories.index'))->with('success', "Kategorija obrisana.");
    }
}
