<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MenuModel extends Model
{
    protected $table = 'menu';

    public $timestamps = false;

    protected $guarded = ['_token'];

    protected $fillable=['name','p_id','route','icon','param','remark','state','level'];

    public function getTree(){
        return $this->hasMany('App\AdminModel\MenuModel','p_id');
    }

    /*
     * ----------------------------------
     * update batch
     * ----------------------------------
     *
     * multiple update in one query
     *
     * tablename( required | string )
     * multipleData ( required | array of array )
    */
    public static function updateBatch($tableName, $multipleData = array()){
        if( $tableName && !empty($multipleData) ) {
            // column or fields to update
            $updateColumn = array_keys($multipleData[1]);
            $referenceColumn = $updateColumn[1]; //e.g id
            unset($updateColumn[1]);
            $whereIn = "";

            $q = "UPDATE ".$tableName." SET ";
            foreach ( $updateColumn as $uColumn ) {
                $q .=  $uColumn." = CASE ";

                foreach( $multipleData as $data ) {
                    $q .= "WHEN ".$referenceColumn." = ".$data[$referenceColumn]." THEN '".$data[$uColumn]."' ";
                }
                $q .= "ELSE ".$uColumn." END, ";
            }
            foreach( $multipleData as $data ) {
                $whereIn .= "'".$data[$referenceColumn]."', ";
            }
            $q = rtrim($q, ", ")." WHERE ".$referenceColumn." IN (".  rtrim($whereIn, ', ').")";
            // Update
            return DB::update(DB::raw($q));

        } else {
            return false;
        }
    }

    //排练
    public static function getTreeJoin($tree){
        static $arr = [];
        foreach($tree as $val){
            $arr[] = $val;
            if(isset($val['getTree']) && !empty($val['getTree'])){
                self::getTreeJoin($val['getTree']);
            }
        }
        return $arr;
    }

    //获取所有路由
    public static function getRouteAll() {
        return self::where('state',0)->pluck('route')->toArray();
    }
}
