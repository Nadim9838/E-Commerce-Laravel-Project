<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Product;
use App\Models\Admin\ProductAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function index(Product $product)
    {
        return response()->json($product->attributes);
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        $product->attributes()->create($request->only('key', 'value'));

        return response()->json(['success' => true]);
    }

    public function update(Request $request, ProductAttribute $attribute)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        $attribute->update($request->only('key', 'value'));

        return response()->json(['success' => true]);
    }

    public function destroy(ProductAttribute $attribute)
    {
        $attribute->delete();

        return response()->json(['success' => true]);
    }
}
