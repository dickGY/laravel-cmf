@extends('admin.admin')

@section('body-class','login-bg')
@section('content')
    <div class="login layui-anim layui-anim-up">
        <div class="message">laravel-cmf-管理登录</div>
        <div id="darkbannerwrap"></div>

        <form method="post" class="layui-form" >
            {{csrf_field()}}
            <input name="mobile" placeholder="手机号"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="user_pass" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(function  () {
            layui.use('form', function(){
                var form = layui.form;
                console.log(form)
                //监听提交
                form.on('submit(login)', function(data){
                    console.log(data.field);
                    $.post("{{url('admin/doLogin')}}",data.field,function(result) {
                        if(result.code == 0){
                            $.each(result.errors,function(k,v) {
                                layer.msg(v, {icon: 2});
                                return false;
                            })
                        }else{
                            layer.msg("登陆成功", {icon: 1},function () {
                                location.href="{{url('admin/')}}"
                            });
                        }
                    });
                    return false;
                });
            });
        })
    </script>
@endsection