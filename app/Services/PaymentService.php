<?php

namespace App\Services;
class PaymentService
{
    public function __construct($serviceType)
    {
        $this->type = $serviceType;
    }

}
