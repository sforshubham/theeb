<?php

namespace App\Soap\Request;

class GetVehicleType
{
  /**
   * @var string
   */
  protected $VehicleType;

  /**
   * @var string
   */
  protected $Password;

  /**
   * VehicleType constructor.
   *
   * @param string $VehicleType
   * @param string $Password
   */
  public function __construct($VehicleType = '')
  {
    $this->VehicleType = $VehicleType;
  }
}