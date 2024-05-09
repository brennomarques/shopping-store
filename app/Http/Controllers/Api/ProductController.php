<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductValidator;
use App\Http\Resources\ProductResource;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection|ProductResource|Response
     */
    public function index(Request $request): AnonymousResourceCollection | ProductResource | Response
    {

        if ($request->has('q')) {
            $searchQuery = $request->query('q');
            return static::show($searchQuery);
        }

        $products = Products::paginate(10);
        return ProductResource::collection($products);
    }

    /**
     * Show the form for creating a new resource.
     * @return void
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param ProductValidator $request
     * @return ProductResource|Response
     */
    public function store(ProductValidator $request): ProductResource | Response
    {

        $input = $request->all();

        $existingProduct = Products::where('barcode', $input['barcode'])->first();
        if ($existingProduct) {
            return response(['message' => 'The product is already registered.'], Response::HTTP_BAD_REQUEST);
        }

        $product = Products::create(
            [
                'barcode' => $input['barcode'],
                'name' => $input['name'],
                'price'  => $input['price'],
                'qty_stock' => $input['qty_stock'],
            ]
        );

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     * @param string $uuid
     * @return ProductResource|Response
     */
    public function show(string $uuid): ProductResource | Response
    {
        $search = Products::where('uuid', $uuid)->first();

        if (!$search) {
            return response(['message' => 'product not found'], Response::HTTP_NOT_FOUND);
        }

        return new ProductResource($search);
    }

    /**
     * Show the form for editing the specified resource.
     * @param string $uuid
     * @return void
     */
    public function edit(string $uuid): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string  $uuid
     *
     * @return ProductResource
     */
    public function update(Request $request, string $uuid): ProductResource | Response
    {

        $product = Products::where('uuid', $uuid)->first();

        if (!$product) {
            return response(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $product->fill($request->all());
        $product->save();

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     * @param string $barcode
     * @return Response
     */
    public function destroy(string $barcode): Response
    {

        $product = Products::where('barcode', $barcode)->first();

        $uuid = $product->uuid;

        if (!$product) {
            return response(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $product->delete();

        return new response(['message' => 'Product deleted', 'id' => $uuid, 'barcode' => $barcode], Response::HTTP_OK);
    }
}
