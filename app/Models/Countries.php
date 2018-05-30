<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Countries extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';
    protected $uniqueKey = 'code';
    public $timestamps = false;

    public static function getAll()
    {
        $rows = self::pluck('name','code');
        if (!$rows->count()) {
            $rows = [];
        }
        return $rows;
    }


}
