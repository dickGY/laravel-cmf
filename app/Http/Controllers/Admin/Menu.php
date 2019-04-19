<?php
/**
 * Created by PhpStorm.
 * User: AdministratorModel
 * Date: 2019/4/2
 * Time: 10:53
 */

namespace App\Http\Controllers\Admin;


use App\AdminModel\MenuModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Menu extends Controller
{

    public function index(){
        $data = MenuModel::getTreeJoin(MenuModel::with(['getTree'=>function($query) {$query->with(['getTree'=>function($query) {$query->with('getTree');}]);}])->where('p_id',0)->get());
        return view('admin.menu.index',[
                'data'=>$data,
            ]);
    }

    //操作菜单
    public function saveMenu($id=0, $action=false){
        return view('admin.menu.save_menu',[
            'action'=>$action,
            'id' => $id,
            'parent' => MenuModel::with(['getTree'=>function($query) {$query->with('getTree');}])->where('p_id',0)->get(),
            'data' => MenuModel::find($id),
        ]);
    }
    //执行操作
    public function doSaveMenu(Request $request){
        $post = $request->post();
        $action = false;
        if(empty($post['action'])){
            $validator = Validator::make($post,
                ['name' => 'required','route' => 'required',],
                ['required' => ' :attribute 必须输入'],
                ['name' => '菜单名称','route'=>'路由地址']
            );
            if($validator->fails()){
                return response()->json(['code'=>'0','errors'=>$validator->getMessageBag()->toArray()]);
            }
            $post['route'] = '/' . ltrim($post['route'],'/');
        }
        DB::beginTransaction();
        try{
            if(empty($post['id']) && empty($post['action'])){
                MenuModel::create($post);
            }else{
                if(!empty($post['action']) && $post['action'] == 'rank'){
                    $action = true;
                    MenuModel::updateBatch('menu',$post['data']);
                }else{
                    unset($post['_token']);
                    if(!empty($post['action'])) unset($post['action']);$action = true;
                    $oldMenu = MenuModel::find($post['id']);
                    MenuModel::where('id',$post['id'])->update($post);
                }
            }

            if(!$action){
                $authrole = DB::table('auth_rule')->where('route',$post['route'])->first();
                if(empty($authrole)){
                    DB::table('auth_rule')->insert([
                        'name' => $post['name'],'param' => $post['param'], 'route' => $post['route']
                    ]);
                }
                if(!empty($post['id'])){
                    if(!empty($authrole)){
                        DB::table('auth_rule')
                            ->where('id',$authrole->id)
                            ->update(['name' => $post['name'],'param' => $post['param'], 'status'=>1]);
                    }else{
                        DB::table('auth_rule')->where('route',$oldMenu['route'])->update(['status'=>0]);
                    }
                }
            }
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['code'=>'0','errors'=>$e->getMessage()]);
        }
        DB::commit();
        return response()->json(['code'=>'1']);
    }

    //执行删除
    public function doDele(Request $request) {
        $id = $request->post('id');

        $isSon = MenuModel::where('p_id',$id)->count();
        if($isSon){
            return response()->json(['code'=>'0','errors'=>'请先删除子级菜单']);
        }

        MenuModel::destroy($id);
        return response()->json(['code'=>'1']);
    }
}