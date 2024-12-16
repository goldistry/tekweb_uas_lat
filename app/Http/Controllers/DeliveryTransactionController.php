<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTransaction;
use Illuminate\Http\Request;

class DeliveryTransactionController extends BaseController
{
    public function __construct(DeliveryTransaction $deliveryTransaction)
    {
        parent::__construct($deliveryTransaction);
    }
}
