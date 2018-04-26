<?php

namespace App\Soap\Request;

class GetDriverProfile
{
  /**
   * @var string
   */
  protected $IDNo;

  /**
   * DriverProfile constructor.
   *
   * @param string $IDNo
   */
  public function __construct($IDNo)
  {
    $this->IDNo = $IDNo;
  }
}