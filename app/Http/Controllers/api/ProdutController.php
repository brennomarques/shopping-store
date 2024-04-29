<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        //
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
            return response(['message' => 'product not found'], Response::HTTP_OK);
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
     * @return void
     */
    public function update(Request $request, string $uuid): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param string $uuid
     * @return void
     */
    public function destroy(string $uuid): void
    {
        //
    }
}
