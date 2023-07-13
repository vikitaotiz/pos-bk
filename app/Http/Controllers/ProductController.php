<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Http\Resources\Products\ProductResource;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        // $user = auth()->user();

        // if(in_array("Administrator", $user->roles->pluck("name")->toArray())){
        return ProductResource::collection(Product::orderBy('created_at', 'desc')->get());
        // };
    }

    public function store(Request $request)
    {
        $product = Product::where(['name'=> $request->name])->first();
        $user_id = User::where("uuid", $request->uuid)->first()->id;

        if($product) return response()->json([
            'status' => 'error',
            'message' => 'Product already exists.',
        ]);

        Product::create([
            'name' => $request->name,
            'user_id' => $user_id,
            'uuid' => Str::uuid()->toString()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully.',
        ]);
    }

    public function update(Request $request)
    {
        $product = Product::where("uuid", $request->uuid)->first();

        if(!$product) return response()->json([
            'status' => 'error',
            'message' => 'Product does not exists.',
        ]);

        $product->update([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully.',
        ]);
    }

    public function destroy(Request $request)
    {
        $product = Product::where("uuid", $request->uuid)->first();
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.',
            'status' => 'success'
        ]);
    }
}
