<?php
namespace App\Models;

class Stock extends ModelBase
{
  public $id;
  public $productName;
  public $productDescription;
  public $onHand;
  public $price;
  public $status;
  public $productImage;
}
