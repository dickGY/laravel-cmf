<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//后台路由管理
Route::group([
    'prefix'=>'admin'
], function ($route) {
    // 登录
    $route->get('login', 'Admin\Administrator@login');
    $route->post('doLogin', 'Admin\Administrator@doLogin');

    $route->group(['middleware' => ['admin.login.check']], function ($route) {
        /**
         * 后台管理
         */
        $route->get('outLogin', 'Admin\Administrator@outLogin');//退出登陆

        $route->get('/','Admin\Index@index');//首页
        $route->get('/welcome','Admin\Index@welcome');//欢迎页面
        $route->get('/icon','Admin\Index@icon');//欢迎页面

        $route->get('/menu','Admin\Menu@index');//菜单列表管理
        $route->get('/menu_add/{p_id?}','Admin\Menu@saveMenu');//操作菜单
        $route->get('/menu_edit/{id}/{action}','Admin\Menu@saveMenu');//操作菜单
        $route->post('/doSaveMenu','Admin\Menu@doSaveMenu');//执行操作菜单
        $route->post('/doDeleMenu','Admin\Menu@doDele');//执行删除菜单

        $route->group(['middleware' => ['admin.menu.route.check']], function($route) {

            $route->any('/administrator','Admin\Administrator@index');//管理员列表
            $route->get('/saveAdministrator/{id?}','Admin\Administrator@saveAdmin');//操作管理员
            $route->post('/doSaveAdministrator','Admin\Administrator@doSaveAdmin');//操作管理员

            $route->get('/role','Admin\Role@index');//角色列表
            $route->get('/saveRole/{id?}','Admin\Role@saveRole');//操作角色
            $route->post('/doSaveRole','Admin\Role@doSaveRole');//执行操作角色
            $route->post('/doDeleRole','Admin\Role@doDele');//删除角色
            $route->get('/allot/{id}','Admin\Role@allot');//权限授权
            $route->post('/doAllot','Admin\Role@doAllot');//执行权限授权
        });
    });
});