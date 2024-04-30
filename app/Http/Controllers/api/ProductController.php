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

class ProductController extends Controller
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

        $orderedUuid = (string) Str::orderedUuid();
        $product = new Products();

        $product->fill(
            [
                'uuid' => $orderedUuid,
                'barcode' => $input['barcode'],
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
     * @param string $barcode
     * @return ProductResource|Response
     */
    public function show(string $barcode): ProductResource | Response
    {
        $search = Products::where('barcode', $barcode)->first();

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
     * @param string  $barcode
     *
     * @return ProductResource
     */
    public function update(Request $request, string $barcode): ProductResource | Response
    {

        $product = Products::where('barcode', $barcode)->first();

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
