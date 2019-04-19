<?php
/**
 * Created by PhpStorm.
 * User: AdministratorModel
 * Date: 2019/4/8
 * Time: 15:59
 */

namespace App\Http\Controllers\Admin;


use App\AdminModel\MenuModel;
use App\AdminModel\RoleModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Role extends Controller
{

    //角色管理
    public function index(){
        return view('admin.role.index',[
            'data' => RoleModel::all()
        ]);
    }

    //操作角色
    public function saveRole($id=false) {
        return view('admin.role.save_role',[
            'data' => RoleModel::find($id)
        ]);
    }

    //执行操作
    public function doSaveRole(Request $request) {
        $post = $request->post();
        if(empty($post['action'])){
            $validator = Validator::make($post,
                ['name' => 'required','state' => 'required'],
                ['required' => ' :attribute 必须输入'],
                ['name'=>'角色名称','state'=>'状态']
            );
            if($validator->fails()){
                return response()->json(['code'=>'0','errors'=>$validator->getMessageBag()->toArray()]);
            }
        }

        if(empty($post['id'])){
            RoleModel::create($post);
        }else{
            unset($post['_token']);unset($post['action']);
            RoleModel::where('id',$post['id'])->update($post);
        }
        return response()->json(['code'=>'1']);
    }

    //执行删除
    public function doDele(Request $request) {
        $id = $request->post('id');

        RoleModel::destroy($id);
        return response()->json(['code'=>'1']);
    }

    //权限分配
    public function allot($id) {
        $accessRoute = DB::table('auth_access')->where('role_id',$id)->pluck('rule_route')->toArray();
        $menu = MenuModel::getTreeJoin(MenuModel::with(['getTree'=>function($query) {$query->with(['getTree'=>function($query) {$query->with('getTree');}]);}])->where('p_id',0)->get());
        return view('admin.role.allot',[
            'accessRoute' => $accessRoute,
            'menu' => $menu,
            'role_id' => $id
        ]);
    }

    //执行权限授权
    public function doAllot(Request $request){
        $post = $request->post();
        DB::beginTransaction();
        try{
            DB::table('auth_access')->where('role_id',$post['role_id'])->delete();
            if(!empty($post['rule_route'])){
                $data = [];
                foreach ($post['rule_route'] as $v){
                    $data[] = ['role_id'=>$post['role_id'],'rule_route'=>$v];
                }
                DB::table('auth_access')->insert($data);
            }
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['code'=>'0','errors'=>$e->getMessage()]);
        }
        DB::commit();
        return response()->json(['code'=>'1']);
    }
}