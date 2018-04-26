<?php

namespace App\Soap\Request;

class GetSoapRequest
{

  /**
   * Login constructor.
   *
   * @param string $UserName
   * @param string $Password
   */
  public function __construct($input)
  {
    foreach ($input as $key => $value) {
      $this->$key = $value;
    }
  }
}