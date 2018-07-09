<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionNotification extends Model
{
    public function setResponseAttribute($value)
    {
        $this->attributes['response'] = json_encode($value);
    }

    public function insertIntoDB($value)
    {
        $obj = self;
        $obj->response = $value;
        $obj->save();
    }
}
