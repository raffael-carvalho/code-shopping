<?php

namespace CodeShopping\Http\Controllers\Api;

use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Models\ProductOutput;
use Illuminate\Http\Request;
use CodeShopping\Http\Resources\ProductOutputResource;
use CodeShopping\Http\Requests\ProductOutputRequest;


class ProductOutputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outputs = ProductOutput::with('product')->paginate();
        return ProductOutputResource::collection($outputs);
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
    public function store(ProductOutputRequest $request)
    {
        $output = ProductOutput::create($request->all());
        return new ProductOutputResource($output);
    }

    /**
     * Display the specified resource.
     *
     * @param  \CodeShopping\Models\ProductOutput  $productOutput
     * @return \Illuminate\Http\Response
     */
    public function show(ProductOutput $output)
    {
        return new ProductOutputResource($output);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CodeShopping\Models\ProductOutput  $productOutput
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductOutput $productOutput)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CodeShopping\Models\ProductOutput  $productOutput
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductOutput $productOutput)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CodeShopping\Models\ProductOutput  $productOutput
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductOutput $productOutput)
    {
        //
    }
}
