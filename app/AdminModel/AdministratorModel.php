<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class AdministratorModel extends Model
{
    protected $table = 'admin';

    public $timestamps = false;

    protected $guarded = ['_token','repass'];

    protected $fillable=['create_time','user_status','user_pass','user_nickname','mobile','email','role_id'];

    public static function validate($post){
        $m = ['required','regex:'.cmf_phone_rule()];
        if(empty($post['id'])){
            $m[] = 'unique:admin';
        }
        return Validator::make($post,
            [
                'user_nickname' => 'required',
                'mobile' => $m,
                'email'=> ['required','email'],
                'user_pass' => 'required_without:id|digits_between:6,16|required_without:id',
                'repass' => 'required_without:id|same:user_pass',
                'role_id' => 'required'
            ],
            [
                'required' => ' :attribute 必须输入',
                'regex' =>' :attribute 格式不正确',
                'email' =>' :attribute 格式不正确',
                'digits_between' =>' :attribute 的字符数量必须介于6-16位之间',
                'same' => '两次密码不正确',
                'unique' => ' :attribute 已存在'
            ],
            ['user_nickname'=>'姓名','mobile'=>'手机号','email'=>'邮箱','user_pass'=>'密码','repass'=>'确认密码','role_id'=>'角色']
        );
    }

    public function getRole(){
        return $this->hasOne('App\AdminModel\RoleModel','id','role_id');
    }

}
