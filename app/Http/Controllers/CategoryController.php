<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index (){
        $no = 0;

        $data = Category::paginate(5);

        foreach ($data as $d) {
            $d->no = $no+=1;
        }
        return view('category.index', compact('data'));
    }

    public function create(){
        return view('category.create');
    }
    
    public function store(Request $request) {

        $cek = Category::where('name', $request->name)->first();

        if($cek) {

            session()->flash('message', "Category $request->name sudah ada");
            return redirect('/category');
            
        }

        $category = new Category();
        $category->name = $request->name;
        $category->supplier = $request->supplier;
        $category->quantity = $request->quantity;
        $category->entery_date = $request->entery_date;
        $category->expired = $request->expired;
        $category->save();

        return redirect('/category');

    }

    public function edit ($id){
        $data = Category::where('id', $id)->first();
        return view('category.edit', compact('data'));
    }

    public function update (Request $request, $id){
        $validate = Category::where('id', $id)->where('id', '!=', $id)->first();

        if($validate) {

            session()->flash('message', "Category $request->name sudah ada");
            return redirect('/category');
            
        }

        $data = Category::where('id', $id)->first();
        $data->name = $request->name;
        $data->quantity = $request->quantity;
        $data->status_active = $request->status_active;
        $data->update();

        return redirect('/category');
    }

    public function destroy($id){
        $data = Category::where('id', $id)->delete();

        return redirect('/category');
    }

    public function  search(Request $request){
        // $search = $request->search;
        $no = 0;
        $data = Category::where('name', 'LIKE', "%$request->search%")->paginate(5);

        foreach ($data as $d) {
            $d->no = $no+=1;
        }

        return view('category.index',compact('data'));
        // $cari = $request->cari;
    }
}
