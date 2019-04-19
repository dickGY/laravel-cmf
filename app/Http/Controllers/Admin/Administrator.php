<?php
/**
 * Created by PhpStorm.
 * User: AdministratorModel
 * Date: 2019/4/1
 * Time: 10:30
 */

namespace App\Http\Controllers\Admin;


use App\AdminModel\AdministratorModel;
use App\AdminModel\RoleModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Administrator extends Controller
{

    /**
     * 登陆页面
     */
    public function login () {
        return view('admin.administrator.login');
    }
    //验证登陆
    public function doLogin (Request $request) {
        $post = $request->post();
        $validator = Validator::make($post,
            ['mobile' => ['required','regex:'.cmf_phone_rule()],'user_pass' => 'required',],
            ['required' => ' :attribute 必须输入','regex' =>' :attribute 格式不正确',],
            ['mobile'=>'手机号','user_pass'=>'密码']
        );
        if($validator->fails()){
            return response()->json(['code'=>0,'errors'=>$validator->getMessageBag()->toArray()]);
        }
        $admin = AdministratorModel::where('mobile',$post['mobile'])->first();
        if(empty($admin)) return response()->json(['code'=>0,'errors'=>['管理员不存在']]);

        if($admin['user_pass'] != md5(md5($post['user_pass'])))  return response()->json(['code'=>0,'errors'=>['密码不正确,请输入正确密码']]);

        $request->session()->put(['admin_id'=>$admin['id'],'role_id'=>$admin['role_id']]);
        return response()->json(['code'=>'1']);
    }

    //退出登陆
    public function outLogin(Request $request){
        $request->session()->flush();
        return redirect('admin/');
    }

    //管理元列表
    public function index(Request $request){
        $param = $request->all('param')['param'];
        return view('admin.administrator.index',[
            'data' => AdministratorModel::with('getRole')
                ->where(function ($query) use($param) {
                    if(!empty($param['bName'])){
                        $query -> orWhere('user_nickname', 'like', '%'.$param['bName'].'%');
                        $query -> orWhere('mobile', 'like', '%'.$param['bName'].'%');
                    }
                })->orderByDesc('create_time')->paginate(10),
            'param' => $param
        ]);
    }

    //操作管理员
    public function saveAdmin($id=false){
        return view('admin.administrator.save_admin',[
            'role' => RoleModel::where('state',0)->get(),
            'data' => AdministratorModel::find($id)
        ]);
    }

    //执行操作
    public function doSaveAdmin(Request $request) {
        $post = $request->post();
        if(empty($post['action'])){
            $validator = AdministratorModel::validate($post);
            if($validator->fails()){
                return response()->json(['code'=>'0','errors'=>$validator->getMessageBag()->toArray()]);
            }
        }

        if(empty($post['id'])){
            $post['create_time'] = date('Y-m-d H:i:s',time());
            $post['user_pass'] = md5(md5($post['user_pass']));
            AdministratorModel::create($post);
        }else{
            unset($post['_token']);unset($post['action']);
            AdministratorModel::where('id',$post['id'])->update($post);
        }
        return response()->json(['code'=>'1']);
    }
}