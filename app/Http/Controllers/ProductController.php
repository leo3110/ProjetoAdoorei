<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index($category = null,$name = null) {
        if ($category&&$name) $query = DB::table('product')->where('category','=',$category)->where('name','=',$name)->get();
        else if ($category) $query = DB::table('product')->where('category','=',$category)->get();
        else if ($name) $query = DB::table('product')->where('name','=',$name)->get();
        else $query = DB::table('product')->get();
        return view('welcome',['query' => $query]);
    }
    public function queryAll() {
        $query = DB::table('product')->get();
        return $query;
    }

    public function createProduct(Request $request) {
        $prod = new Product();
        $prod->name = $request->name;
        $prod->price = $request->price;
        $prod->description = $request->description;
        $prod->category = $request->category;
        $prod->image_url = $request->image_url;
        $prod->save();
        return response()->json(["message" => "Product succesfully created!"], 201);
    }

    public function query($id = '*', $name = '*', $category = '*', $image_url = !null) {
        $query = DB::table('product')->where([
            ['id','=',$id],
            ['name','=',$name],
            ['category','=',$category],
            ['image_url','=',$image_url]
            ])->get();
        return $query;
    }

    public function updateProduct(Request $request, $id) {

    }

    public function deleteProduct ($id) {

    }
}
