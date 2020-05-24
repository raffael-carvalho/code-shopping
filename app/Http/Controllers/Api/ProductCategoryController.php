<?php

namespace CodeShopping\Http\Controllers\Api;

use Illuminate\Http\Request;
use CodeShopping\Http\Requests\ProductCategoryRequest;
use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Models\Product;
use CodeShopping\Models\Category;
use Illuminate\Database\Eloquent\Collectio;
use CodeShopping\Http\Resources\ProductCategoryResource;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return  new ProductCategoryResource($product);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request, Product $product)
    {
        $changed = $product->categories()->sync($request->categories);
        $categoriesAttacheldId = $changed['attached'];
        $categories = Category::whereIn('id',$categoriesAttacheldId)->get();

        return $categories->count() ? response()->json(new ProductCategoryResource($product), 201) : [];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
        $product->categories()->detach($category->id);

        return response()->json([],204);
    }
}
