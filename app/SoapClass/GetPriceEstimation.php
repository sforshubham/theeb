<?php

namespace App\Soap\Request;

class GetPriceEstimation
{
  /*protected $OutBranch;
  protected $InBranch;
  protected $OutDate;
  protected $OutTime;
  protected $InDate;
  protected $InTime;*/

  /**
   * PriceEstimation constructor.
   *
   * @param string $UserName
   * @param string $Password
   */
  public function __construct($input)
  {
    $this->Price = $input;/*
    $this->OutBranch = $input['OutBranch'];
    $this->InBranch = $input['InBranch'];
    $this->OutDate = $input['OutDate'];
    $this->OutTime = $input['OutTime'];
    $this->InDate = $input['InDate'];
    $this->InTime = $input['InTime'];*/
  }
}