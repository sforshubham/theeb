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
        $rows = self::select('BranchCode', 'BranchName');
        if ($rows->count()) {
            $rows = $rows->get()->toArray();
        } else {
            $rows = [];
        }
        return $rows;
    }
}
