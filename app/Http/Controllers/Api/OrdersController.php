<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\CreateOrderRequest;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Services\CheckStockService;
use App\Services\SubtractStockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OrdersController extends BaseController
{
    /**
     * Create a new instance OrdersController.
     *
     * @param CheckStockService    $checkStockService
     * @param SubtractStockService $subtractStockService
     */
    public function __construct(
        protected CheckStockService $checkStockService,
        protected SubtractStockService $subtractStockService
    ) {
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateOrderRequest $request
     * @return JsonResponse JsonResponse
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        $input = $request->all();

        $this->checkStockService->validatesStock($input['products']);

        $order = Orders::create(
            [
                'name' => $input['name'],
                'client_id' => $request->user()->id,
                'delivery_at'  => $input['delivery_at'],
                'status' => Orders::WAITING,
            ]
        );

        foreach ($input['products'] as $product) {
            $subtractStock = $this->subtractStockService->subtrairStock($product);

            $productId = $subtractStock->id;
            $orderId = $order->id;

            OrderItems::create(
                [
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'quantity'  => $product['quantity'],
                    'price' => $subtractStock->price,
                ]
            );

            // Garante que a compra foi finalizada
            $order->status = Orders::FINISH;
            $order->save();
        }

        return $this->sendResponse('Order completed successfully.', Response::HTTP_OK);
    }
}
