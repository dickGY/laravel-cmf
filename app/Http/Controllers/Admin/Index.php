<?php
/**
 * Created by PhpStorm.
 * User: AdministratorModel
 * Date: 2019/4/1
 * Time: 18:04
 */

namespace App\Http\Controllers\Admin;


use App\AdminModel\AdministratorModel;
use App\AdminModel\MenuModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Index extends Controller
{

    //后台首页
    public function index() {
        if(cmf_role_id() == 1){
            $routes = MenuModel::getRouteAll();
        }else{
            $routes = DB::table('auth_access')->where('role_id',cmf_role_id())->pluck('rule_route')->toArray();
        }
        return view('admin.index.index',[
            'menu' => MenuModel::with([
                'getTree'=>function($query) use($routes) {
                    $query->with([
                        'getTree' => function($query) use($routes) {
                            $query->whereIn('route',$routes);
                        }
                    ])->whereIn('route',$routes);
                }])->where(['p_id'=>0,'state'=>0])->get(),
            'admin' => AdministratorModel::find(Session::get('admin_id'))
        ]);
    }

    //欢迎页面
    public function welcome() {
        return view('admin.index.welcome');
    }

    //icon页面
    public function icon() {
        return view('admin.index.icon');
    }
}