<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductValidator;
use App\Http\Resources\ProductResource;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class ProdutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection|ProductResource
     */
    public function index(Request $request): AnonymousResourceCollection | ProductResource
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
     * @return ProductResource
     */
    public function store(ProductValidator $request): ProductResource
    {
        $orderedUuid = (string) Str::orderedUuid();

        $input = $request->all();

        $product = new Products();

        $product->fill(
            [
                'uuid' => $orderedUuid,
                'name' => $input['name'],
                'price'  => $input['price'],
                'qty_stock' => $input['qty_stock'],
            ]
        );

        $product->save();

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     * @param string $uuid
     * @return ProductResource
     */
    public function show(string $uuid): ProductResource
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
     * @param string $uuid
     * @return Response
     */
    public function destroy(string $uuid): Response
    {

        $product = Products::where('uuid', $uuid)->first();

        if (!$product) {
            return response(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $product->delete();

        return new response(['message' => 'Product deleted', 'id' => $uuid], Response::HTTP_OK);
    }
}
