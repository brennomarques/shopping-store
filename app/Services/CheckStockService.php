<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Products;
use Exception;
use Illuminate\Support\Facades\Log;

class CheckStockService
{
    private const ZERO_STOCK = 0;

    /**
     * Validates product stock
     *
     * @param mixed $productList
     *@return ProductResource
     */
    public function validatesStock($productList): ProductResource
    {
        foreach ($productList as $product) {
            $searchProduct = Products::where('uuid', $product['id'])->first();

            if (!$searchProduct) {
                Log::info('product not found: ' . $product['id'] . ' ' . __METHOD__);
                throw new Exception('product not found: ' . $product['id']);
            }

            if ($searchProduct->qty_stock == CheckStockService::ZERO_STOCK) {
                Log::info('O produto está sem estoque: ' . $product['id'] . ' ' . __METHOD__);
                throw new Exception('O produto está sem estoque, ID:' . $product['id']);
            }

            if ($searchProduct->qty_stock < $product['quantity']) {
                Log::info('Não há quantidade solicitada em estoque: ' . $product['id'] . ' ' . __METHOD__);
                throw new Exception('Não há quantidade solicitada em estoque: ' . $searchProduct->name);
            }
        }

        return new ProductResource($productList);
    }
}
