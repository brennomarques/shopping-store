<?php

namespace App\Http\Controllers\api;

use App\Helpers\ReadCsvFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFileValidator;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use SplFileObject;

class ProductFileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param ProductFileValidator $request
     * @return Response
     */
    public function store(ProductFileValidator $request)
    {

        $file = $request->file('file');
        $filePath = $file->getRealPath();

        $Products = ReadCsvFile::readFileContents($filePath);

        foreach ($Products as $row) {
            $orderedUuid = (string) Str::orderedUuid();
            $product = new Products(
                [
                    'uuid' => $orderedUuid,
                    'name' => $row[1],
                    'price' => $row[2],
                    'qty_stock' => $row[3],
                ]
            );

            $product->save();
        }

        return response()->json(['message' => 'Products imported successfully'], Response::HTTP_OK);
    }
}
