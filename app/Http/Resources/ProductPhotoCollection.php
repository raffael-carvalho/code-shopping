<?php

namespace CodeShopping\Http\Resources;

use CodeShopping\Models\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductPhotoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private $product;

    public function __construct($resource,Product $product){
        $this->product = $product;
        parent::__construct($resource);
    }


    public function toArray($request)
    {
        return [
            'product' => new ProductResource($this->product),
            'photos' => $this->collection->map(function($photo){
                return new ProductPhotoResource($photo,true);
            })
        ];
    }
}
