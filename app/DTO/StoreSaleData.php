<?php

namespace app\DTO;

use Spatie\LaravelData\Data;

class StoreSaleData extends Data 
{
    public int $idUser;
    public int $idProduct;
    public int $quantity;

    public function __construct(int $idUser, int $idProduct, int $quantity)
    {
        $this->idUser = $idUser;
        $this->idProduct = $idProduct;
        $this->quantity = $quantity;
    }

}
