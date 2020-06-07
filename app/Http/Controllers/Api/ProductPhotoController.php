<?php

namespace CodeShopping\Http\Controllers\Api;

use CodeShopping\Models\ProductPhoto;
use CodeShopping\Models\Product;
use Illuminate\Http\Request;
use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Resources\ProductPhotoResource;
use CodeShopping\Http\Resources\ProductPhotoCollection;
use CodeShopping\Http\Requests\ProductPhotoRequest;

class ProductPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return new ProductPhotoCollection($product->photos,$product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductPhotoRequest $request, Product $product)
    {
        $photos = ProductPhoto::createWithPhotosFiles($product->id, $request->photos);
        return response()->json(new ProductPhotoCollection($product->photos, $product),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \CodeShopping\Models\ProductPhoto  $productPhoto
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, ProductPhoto $photo)
    {
        $this->assertProductPhoto($product,$photo);
        return new ProductPhotoResource($photo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CodeShopping\Models\ProductPhoto  $productPhoto
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductPhoto $productPhoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CodeShopping\Models\ProductPhoto  $productPhoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product ,ProductPhoto $photo)
    {
        $this->assertProductPhoto($product,$photo);
        $photo = $photo->updateWithPhoto($request->photo);
        return new ProductPhotoResource($photo);
    }

    public function assertProductPhoto(Product $product ,ProductPhoto $photo)
    {
        if($photo->product_id != $product->id){
            abort(404);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \CodeShopping\Models\ProductPhoto  $productPhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductPhoto $productPhoto)
    {
        //
    }
}
