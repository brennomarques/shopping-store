<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Products;
use Exception;
use Illuminate\Http\Response;

class SubtractStockService
{
    /**
     * Subtract from stock method.
     *
     * @param mixed $product
     * @return ProductResource
     */
    public function subtrairStock($product): ProductResource
    {
        $searchProduct = Products::where('uuid', $product['id'])->first();
        if (!$searchProduct) {
            throw new Exception('Product not found');
        }

        if ($searchProduct->qty_stock < $product['quantity']) {
            throw new Exception('Insufficient stock');
        }
        // Subitraçao do estoque
        $searchProduct->qty_stock = ($searchProduct->qty_stock - $product['quantity']);
        $searchProduct->save();

        return new ProductResource($searchProduct);
    }
}
