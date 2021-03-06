<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Branches extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'branches';
    protected $uniqueKey = 'BranchCode';
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
        $rows = self::select('BranchCode', 'BranchName', 'Schedule');
        if ($rows->count()) {
            $rows = $rows->get()->toArray();
        } else {
            $rows = [];
        }
        return $rows;
    }

    public static function getBranchName($codes)
    {
        if (!empty($codes)) {
            $rows = self::whereIn('BranchCode', $codes)
                ->pluck('BranchName','BranchCode');
        } else {
            $rows = self::pluck('BranchName','BranchCode');
        }
        if (!$rows->count()) {
            $rows = [];
        }
        return $rows;
    }
}
