<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){

        $products=Product::all();

        if($products->count()>0){

            return response()->json([
                'status'=>200,
                'products'=>$products],200);
        }else{

            return response()->json([
                'status'=>404,
                'message'=>'No Records Found.'],404);
        }
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(),[

            'product_name'=>'required|max:255',
            'product_desc'=>'required|string',
            'product_price'=>'required|numeric']);

        if($validator->fails()){

            return response()->json([
                'status'=> 422,
                'errors'=> $validator->messages()
            ],422);

        }else{

            $product = Product::create([
                'product_name'=>$request->product_name,
                'product_desc'=>$request->product_desc,
                'product_price'=>$request->product_price,]);

            if($product){

                 return response()->json([
                    'status'=>200,
                    'message' => "Product added successfully."],200);
            }else{

                 return response()->json([
                    'status'=>500,
                    'message' => "Something went wrong."],500);
            }
        }
    } 

    public function show($id) {

        $product=Product::find($id);

        if($product){

             return response()->json([
                    'status'=>200,
                    'product' => $product],200);
        }else{

            return response()->json([
                    'status'=>404,
                    'message' => "Product not found."],404);
        }
    }  

    public function update(Request $request, int $id)

    {

            $validator = Validator::make($request->all(),[
            'product_name'=>'required|max:255',
            'product_desc'=>'required|string',
            'product_price'=>'required|numeric']);

        if($validator->fails()){

            return response()->json([
                'status'=> 422,
                'errors'=> $validator->messages()
            ],422);

        }else{

            $product = Product::find($id);

            if($product){

                $product->update([
                'product_name'=>$request->product_name,
                'product_desc'=>$request->product_desc,
                'product_price'=>$request->product_price,]);

                return response()->json([
                    'status'=>200,
                    'message' => "Product updated successfully."],200);
            }else{

                 return response()->json([
                    'status'=>404,
                    'message' => "Product not found."],404);
            }
        }
    }

    public function destroy($id) {

        $product = Product::find($id);
        
         if($product){

            $product->delete();
            return response()->json([
                    'status'=>200,
                    'message' => "Product deleted successfully."],200);

        }else{

            return response()->json([
                    'status'=>404,
                    'message' => "Product not found."],404);
        }
    }
}