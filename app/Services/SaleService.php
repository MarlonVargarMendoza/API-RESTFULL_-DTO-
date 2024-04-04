<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\String_;

class SaleService
{
    public function createSale(String $userData, array $productsDat)
    {

        try {
            
            DB::beginTransaction();

            $usuario = User::create(['name' => $userData]);

            //Crear array de ventas
            $ventas = [];
            foreach ($productsDat as $data) {
                
                $ventas[] = [
                    'users_id' => $usuario->id,
                    'product_id' => $data['id'],
                    'quantity' => $data['quantity'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            //Calcular total de las ventas
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
            return true;

        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
        
    }

    public function getSale(String $nameClient)
    {

        try {
            $idUser = User::where('name', $nameClient)->select('id')->first();
    
            $userSales = Sale::where('users_id', $idUser['id'])-> get();
            
            $totalPrice = 0;
            $createdAt = '';
            $products = [];
            foreach ($userSales as $data) {
                $totalPrice += $data['total_price'];
                $createdAt = date('Y-m-d H:i:s', strtotime($data['created_at']));
                $products[] = [
                    'id' => $data['id'],
                    'quantity' => $data['quantity'],
                    'total_price' => $data['total_price']
                ];
            }
    
            return $totalSales = [
                'name' => $nameClient,
                'total' => $totalPrice,
                'created_at' => $createdAt,
                'productos' => $products
            ];

        } catch (\Throwable $th) {

            return false;
        }

    }

}
