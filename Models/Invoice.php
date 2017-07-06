<?php

namespace App\Models;

class Invoice extends ModelBase
{
    public $number = "";
    public $date = null;
    public $clientName = "";
    public $amount = 0.0;
}
