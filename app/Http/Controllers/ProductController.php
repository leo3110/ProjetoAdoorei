<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller {

    public function queryProduct($a,$b = null) {
        $b ? $query = DB::table('product')->where('name','=',$a)->where('category','=',$b)->get()
        : $query = DB::table('product')->where('name','=',$a)->orWhere('category','=',$a)->get();
        return $query;
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

    public function updateProduct(Request $request, $id) {
        if (Product::where('id', $id)->exists()) {
            $prod = Product::find($id);
            $prod->name = is_null($request->name) ? $prod->name : $request->name;
            $prod->course = is_null($request->course) ? $prod->course : $request->course;
            $prod->save();        
        }
    }

    public function deleteProduct ($id) {

    }
}
