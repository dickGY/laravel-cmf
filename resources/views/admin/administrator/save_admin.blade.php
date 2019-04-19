@extends('admin.admin')

@section('content')
    <div class="x-body">
        <form class="layui-form">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label for="user_nickname" class="layui-form-label">
                    <span class="x-red">*</span>姓名
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="user_nickname" name="user_nickname" value="{{!empty($data->user_nickname) ? $data->user_nickname : ''}}" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux error-user_nickname">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="mobile" class="layui-form-label">
                    <span class="x-red">*</span>手机
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="mobile" name="mobile" value="{{!empty($data->mobile) ? $data->mobile : ''}}" required="" lay-verify="phone"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux error-mobile">
                    <span class="x-red">*</span>将会成为您唯一的登入账户
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>邮箱
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="email" value="{{!empty($data->email) ? $data->email : ''}}" required="" lay-verify="email"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux error-email"></div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span class="x-red">*</span>角色</label>
                <div class="layui-input-block">
                    @foreach($role as $v)
                        <input type="radio" name="role_id" value="{{$v->id}}"
                               @if(!empty($data->role_id) && $data->role_id == $v->id) checked @endif
                               @if(cmf_role_id() != 1 && $v->id == 1) disabled @endif
                               lay-skin="primary" title="{{$v->name}}">
                    @endforeach
                </div>
                <div class="layui-form-mid layui-word-aux error-role_id"></div>
            </div>
            @if(empty($data->id))
                <div class="layui-form-item">
                    <label for="user_pass" class="layui-form-label">
                        <span class="x-red">*</span>密码
                    </label>
                    <div class="layui-input-inline">
                        <input type="password" id="user_pass" name="user_pass" required="" lay-verify="pass"
                               autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux error-user_pass">
                        <span class="x-red">*</span>6到16个字符
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                        <span class="x-red">*</span>确认密码
                    </label>
                    <div class="layui-input-inline">
                        <input type="password" id="L_repass" name="repass" required="" lay-verify="repass"
                               autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux error-repass"></div>
                </div>
            @endif
            <div class="layui-form-item">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-block">
                    <input type="radio" name="user_status" lay-skin="primary" value="1" title="启用" @if((!empty($data->user_status) && $data->user_status == 1) || empty($data->user_status)) checked @endif >
                    <input type="radio" name="user_status" lay-skin="primary" value="0" title="禁用" @if((!empty($data->user_status) && $data->user_status == 0)) checked @endif >
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                    @if(!empty($data->id))
                        <input type="hidden" name="id" value="{{$data->id}}">
                    @endif
                </label>
                <button  class="layui-btn" lay-filter="add" lay-submit="">
                    保存
                </button>
            </div>
        </form>
    </div>
@endsection

@section('script')
<script>
layui.use(['form','layer'], function(){
    $ = layui.jquery;
    var form = layui.form
        ,layer = layui.layer;
    //监听提交
    form.on('submit(add)', function(data){
        console.log(data.field);
        $.post("{{url('admin/doSaveAdministrator')}}",data.field,function(result) {
            console.log(result);
            if(result.code != 1){
                $.each(result.errors,function(k,v) {
                    $('.error-'+k).html('<span class="x-red">*</span>'+v)
                })
            }else{
                layer.alert("保存成功", {icon: 6},function () {
                    // 获得frame索引
                    var index = parent.layer.getFrameIndex(window.name);
                    //关闭当前frame
                    parent.layer.close(index);
                    parent.window.location.reload();
                });
            }
        },'json');
        return false;
    });
});
</script>
@endsection