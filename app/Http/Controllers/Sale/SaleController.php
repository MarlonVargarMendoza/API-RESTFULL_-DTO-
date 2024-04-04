<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Services\SaleService;

class SaleController extends Controller
{

    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function store(StoreSaleRequest $request)
    {

        $validateData = $request->validated();

        $result = $this->saleService->createSale(
            $validateData['name'],
            $validateData['products']
        );
        
        if ($result) {
            return response()->json(['message' => 'Venta Registrada Correctamente !!!']);
        } else {
            return response()->json(['message' => 'Error Interno !!!'], 500);
        }

    }

    public function getSales($nameClient)
    {
        $totalSales = $this->saleService->getSale($nameClient);

        if ($totalSales == null) {
            return response()->json(['message' => 'No Existe Usuario !!!'], 500);
        } else {
            return response()->json(['Resumen De Venta' => $totalSales]);
        }

    }

}
