<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
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
        if (Product::where('id','=', $id)->exists()) {
            $student = Product::find($id);
            $student->name = is_null($request->name) ? $student->name : $request->name;
            $student->price = is_null($request->price) ? $student->price : $request->price;
            $student->description = is_null($request->description) ? $student->description : $request->description;
            $student->category = is_null($request->category) ? $student->category : $request->category;
            $student->image_url = is_null($request->image_url) ? $student->image_url : $request->image_url;
            $student->save();
        }
    }

    public function deleteProduct ($id) {
        if(Product::where('id','=', $id)->exists()) {
            $prod = Product::find($id);
            $prod->delete();
            return response()->json([
              "message" => "records deleted"
            ], 202);
          } else {
            return response()->json([
              "message" => "Product id/name not found"
            ], 404);
          }
    }
    private function clean() {
        $cleanRequest = $request->validate([
            'name' => 'required|unique:products,name',
            'price' => 'required',
            'description' => 'required',
            'category' => 'required',
            'image_url' => 'required',
        ]);
    }
}
