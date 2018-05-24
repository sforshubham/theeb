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
    protected $uniqueKey = 'Group';
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
        $rows = self::select('VTHCode', 'VTHDesc', 'VTHType', 'Group', 'VehTypeDesc', 'ImageUrl');
        if ($rows->count()) {
            $rows = $rows->get()->toArray();
        } else {
            $rows = [];
        }
        return $rows;
    }

    public static function vehicleType()
    {
        $rows = self::distinct('VTHCode')->select('VTHCode', 'VTHDesc');
        if ($rows->count()) {
            $rows = $rows->get()->toArray();
        } else {
            $rows = [];
        }
        return $rows;
    }

    /**
     * Select vehicles based on vehicle code
     *
     * @return [type] [description]
     */
    public static function getSelectedVehicles($code)
    {
        $rows = self::select('Group', 'VehTypeDesc', 'ImageUrl')
            ->where('VTHCode', (int)$code) ;
        if ($rows->count()) {
            $rows = $rows->get()->toArray();
        } else {
            $rows = [];
        }
        return $rows;
    }

    /**
     * Select vehicles code based on group
     *
     * @return [type] [description]
     */
    public static function getVehCode($group)
    {
        $rows = self::select('VTHCode', 'Group', 'VehTypeDesc', 'ImageUrl', 'VTHDesc')
            ->where('Group', $group) ;
        if ($rows->count()) {
            return $rows->first();
        }
        return false;
    }
}
