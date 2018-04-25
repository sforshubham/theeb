<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class VehicleTypes extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vehicles';
    protected $uniqueKey = 'Code';
    public $timestamps = false;

    public static function updateAll($list = [])
    {
        $result = 0;
        if (!empty($list)) {
            self::truncate();
            $result = self::insert($list);
        }
        return $result;
    }

    public static function getAll()
    {
        $rows = self::select('Code', 'Desc', 'Type');
        if ($rows->count()) {
            $rows = $rows->get()->toArray();
        } else {
            $rows = [];
        }
        return $rows;
    }
}
