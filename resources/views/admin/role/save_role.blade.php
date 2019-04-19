@extends('admin.admin')

@section('content')
    <div class="x-body">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>角色名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="name" name="name" value="{{isset($data->name) ? $data->name : ''}}" required=""
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux error-name">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span class="x-red">*</span>状态</label>
                <div class="layui-input-block">
                    <input type="radio" name="state" lay-skin="primary" value="0" title="启用" @if((!empty($data->state) && $data->state == 0) || empty($data->state)) checked @endif >
                    <input type="radio" name="state" lay-skin="primary" value="1" title="禁用" @if((!empty($data->state) && $data->state == 1)) checked @endif >
                </div>
            </div>
            <div class="layui-form-item">
                <label for="param" class="layui-form-label">
                    备注
                </label>
                <div class="layui-input-inline">
                    <textarea name="remark" lay-verify="remark" autocomplete="off" class="layui-textarea">{{ isset($data->remark)? $data->remark : ''}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                @if(!empty($data->id))
                    <input type="hidden" name="id" value="{{$data->id}}">
                @endif
                {{csrf_field()}}
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
                $.post("{{url('admin/doSaveRole')}}",data.field,function(result) {
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