<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\CreateOrderRequest;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class OrdersController extends BaseController
{
    public const ZERO_STOCK = 0;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrderRequest $request)
    {
        $input = $request->all();

        foreach ($input['products'] as $product) {

            $searchProduct = Products::where('uuid', $product['id'])->first();

            if (!$searchProduct) {
                Log::info('product not found: ' . $product['id'] . ' ' . __METHOD__);
                return $this->sendError(['message' => 'product not found', 'id' => $product['id']], Response::HTTP_NOT_FOUND);
            }

            if ($searchProduct->qty_stock == OrdersController::ZERO_STOCK) {
                Log::info('O produto está sem estoque: ' . $product['id'] . ' ' . __METHOD__);
                return $this->sendError(['message' => 'O produto está sem estoque', 'id' => $product['id']], Response::HTTP_CONFLICT);
            }

            if ($searchProduct->qty_stock < $product['quantity']) {
                Log::info('Não há quantidade solicitada em estoque: ' . $product['id'] . ' ' . __METHOD__);
                return $this->sendError(['message' => 'Não há quantidade solicitada em estoque', 'id' => $product['id']], Response::HTTP_CONFLICT);
            }
        }

        $order = Orders::create(
            [
                'name' => $input['name'],
                'client_id' => $request->user()->id,
                'delivery_at'  => $input['delivery_at'],
                'status' => Orders::WAITING,
            ]
        );

        foreach ($input['products'] as $product) {

            $searchProduct = Products::where('uuid', $product['id'])->first();

            // Subitraçao do estoque
            $searchProduct->qty_stock = ($searchProduct->qty_stock - $product['quantity']);
            $searchProduct->save();

            $productId = $searchProduct->id;
            $orderId = $order->id;

            OrderItems::create(
                [
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'quantity'  => $product['quantity'],
                    'price' => $searchProduct->price,
                ]
            );

            // Garante que a compra foi finalizada
            $order->status = Orders::FINISH;
            $order->save();
        }

        return $this->sendResponse('Order completed successfully.', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
