<?php
/**
 * 自定义函数
 * User: AdministratorModel
 * Date: 2019/4/9
 * Time: 11:49
 */

/**
 * 获取用户
 * @return mixed
 */
function cmf_role_id(){
    $role_id = Session::get('role_id');
    return $role_id;
}

/**
 * 返回手机号码验证正则字符串
 * @return string
 */
function cmf_phone_rule(){
    return '/^1[34578]\d{9}$/';
}

/**
 * 返回邮箱验证正则字符串
 * @return string
 */
function cmf_email_rule() {
    return '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/';
}

