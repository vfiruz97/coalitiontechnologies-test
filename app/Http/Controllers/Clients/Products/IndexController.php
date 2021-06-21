<?php

namespace App\Http\Controllers\Clients\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'products' => Product::all()
        ]);
    }


    public function saveProduct(SaveProductRequest $request)
    {
        $product = new Product(null, $request->productName, $request->quantityInStock, $request->pricePerItem);
        $product->save();

        return response()->json(['status' => 'ok', 'product' => $product->toArray()]);
    }

    public function updateProduct($productId, UpdateProductRequest $request)
    {
        $product = new Product($request->id, $request->productName, $request->quantityInStock, $request->pricePerItem);
        $product->update($productId);

        return response()->json(['status' => 'ok', 'product' => $product->toArray()]);
    }
}
