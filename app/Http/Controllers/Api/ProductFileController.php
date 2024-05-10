<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ReadCsvFile;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductFileValidator;
use App\Models\Products;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ProductFileController extends BaseController
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
            $existingProduct = Products::where('barcode', $row[0])->first();
            if ($existingProduct) {
                return response(
                    [
                        'message' => 'The list contains products that are already registered.'
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            Products::create(
                [
                    'barcode' => $row[0],
                    'name' => $row[1],
                    'price' => $row[2],
                    'qty_stock' => $row[3],
                ]
            );
        }

        return response()->json(['message' => 'Products imported successfully'], Response::HTTP_OK);
    }
}
