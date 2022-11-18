<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Hamcrest\Type\IsBoolean;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller {

    /**
     * Return * from product where name||category||both
     *
     * Return data from table product
     *
     * @param string $a first 'where' works with NAME and CATEGORY
     * @param string $b if true, works as 'and where'
     **/
    public function queryProduct($a,$b = null) {
        $a = $this->clean($a);
        if($b){
            $b = $this->clean($b);
            $query = DB::table('product')->where('name','=',$a)->where('category','=',$b)->get();
        }
        else $query = DB::table('product')->where('name','=',$a)->orWhere('category','=',$a)->get();
        return $query;
    }

    /**
     * Return * from product where img = true
     *
     * Return data from table product
     *
     * @param Boolean $a switches to images on or not
     **/
    public function queryProductImg($a) {
        if ($a === 'true'){
            $query = DB::table('product')->whereNotNull('image_url')->get();
            return $query;            
        }
        else if ($a === 'false'){
            $query = DB::table('product')->whereNull('image_url')->get();
            return $query;
        }
        else return response()->json(["message" => "Variable not Accepted"]);
    }

    public function queryAll() {
        $query = DB::table('product')->get();
        return $query;
    }

    public function createProduct(Request $request) {
        $request = $this->clean($request);
        $prod = new Product();
        $prod->name = $request['name'];
        $prod->price = $request['price'];
        $prod->description = $request['description'];
        $prod->category = $request['category'];
        $prod->image_url = $request['image_url'];
        $prod->save();
        return response()->json(["message" => "Product succesfully created!"], 201);
    }
    
    public function updateProduct(Request $request, $id) {
        if (Product::where('id','=', $id)->exists()) {
            $request = $this->clean($request);
            $prod = Product::find($id);
            $prod->name = is_null($request['name']) ? $prod->name : $request['name'];
            $prod->price = is_null($request['price']) ? $prod->price : $request['price'];
            $prod->description = is_null($request['description']) ? $prod->description : $request['description'];
            $prod->category = is_null($request['category']) ? $prod->category : $request['category'];
            $prod->image_url = $request['image_url'];
            $prod->save();
            return response()->json(["message" => "Product updated"], 202);
        } else return response()->json(["message" => "Product id/name not found"], 404);
    }

    public function deleteProduct ($id) {
        if(Product::where('id','=', $id)->exists()) {
            $prod = Product::find($id);
            $prod->delete();
            return response()->json([
              "message" => "Product deleted"
            ], 202);
          } else {
            return response()->json([
              "message" => "Product id/name not found"
            ], 404);
          }
    }
    private function clean($a) {
        $cleanRequest = $a->validate([
            'name' => 'required|unique:product|max:255',
            'price' => 'required',
            'description' => 'required',
            'category' => 'required|max:255',
            'image_url' => 'nullable|url|max:255'
        ]);
        return $cleanRequest;

    }
}
