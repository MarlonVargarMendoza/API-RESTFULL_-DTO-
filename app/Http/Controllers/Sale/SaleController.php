<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        $validateData = $request->validated();
        
        try {
            
            DB::beginTransaction();

            $usuario = User::create(['name' => $validateData['name']]);

            $ventas = [];
            foreach ($validateData['products'] as $data) {
                
                $ventas[] = [
                    'users_id' => $usuario->id,
                    'product_id' => $data['id'],
                    'quantity' => $data['quantity'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            $productos = Product::get()->toArray();
            foreach ($ventas as $key => $dataVenta) {

                foreach ($productos as $dataProducto) {

                    if ( $dataVenta['product_id'] == $dataProducto['id'] ) {

                        $price = $dataProducto['price'] * $dataVenta['quantity'];
                        $ventas[$key]['total_price'] = $price;
                        break;
                    }
                }
            }
            Sale::insert($ventas);

            DB::commit();
            return response()->json(['Mensaje' => 'Venta Registrada Correctamente !!!']);

        } catch (\Throwable $th) {

            DB::rollBack();
            return response()->json(['Mensaje' => 'Error Interno !!!']);
        }
    }
}
