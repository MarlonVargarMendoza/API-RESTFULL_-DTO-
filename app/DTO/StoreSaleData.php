<?php

namespace App\DTO;

use Spatie\LaravelData\Data;

class StoreSaleData extends Data
{
    public string $nameUser;
    public int $idProduct;
    public int $quantity;

    public function __construct(string $nameUser, int $idProduct, int $quantity)
    {
        $this->nameUser = $nameUser;
        $this->idProduct = $idProduct;
        $this->quantity = $quantity;
    }

}
