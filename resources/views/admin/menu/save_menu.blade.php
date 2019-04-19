@extends('admin.admin')

@section('script-src')
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
@endsection

@section('content')
    <div class="x-body">
        <form class="layui-form">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label for="p_id" class="layui-form-label">
                    <span class="x-red">*</span>父级菜单
                </label>
                @php
                    if($action){
                        $p_id = $data['p_id'];
                    }else{
                        $p_id = $id;
                    }
                @endphp
                <div class="layui-input-inline">
                    <select name="p_id" lay-filter="level"  lay-verify="type">
                        <option value="0" level_="0">顶级菜单</option>
                        @foreach($parent as $v)
                            <option value="{{$v->id}}" @if($v->id == $p_id) selected @endif level_="{{$v->level}}" >{{$v->name}}</option>
                            @foreach($v->getTree as $vv)
                                <option value="{{$vv->id}}" @if($vv->id == $p_id) selected @endif level_="{{$vv->level}}" >&nbsp;&nbsp;&nbsp;&nbsp;|—{{$vv->name}}</option>
                                @foreach($vv->getTree as $vvv)
                                    <option value="{{$vvv->id}}" @if($vvv->id == $p_id) selected @endif level_="{{$vvv->level}}" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|—{{$vvv->name}}</option>
                                @endforeach
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>菜单名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{ isset($data->name) && $action ? $data->name : ''}}" name="name" required="" lay-verify="name"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux x-red error-name">
                    @if($errors->has('phone'))<span class="x-red">*</span>{{$errors->first('phone')}}@endif
                </div>
            </div>
            <div class="layui-form-item">
                <label for="route" class="layui-form-label">
                    <span class="x-red">*</span>菜单路由
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{ isset($data->route) && $action ? $data->route : ''}}" name="route" required="" lay-verify="route"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux x-red error-route">
                    @if($errors->has('route'))<span class="x-red">*</span>{{$errors->first('route')}}@endif
                </div>
            </div>
            <div class="layui-form-item">
                <label for="icon" class="layui-form-label">
                    菜单图标
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{ isset($data->icon) && $action ? $data->icon : ''}}" name="icon" lay-verify="icon"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span><a href="{{url('admin/icon')}}" target="_blank" style="color: #0000FF">点击选择</a>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="param" class="layui-form-label">
                    参数
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{ isset($data->param) && $action ? $data->param : ''}}" name="param" lay-verify="param"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>例：1/4；严格按照laravel路由模式输入
                </div>
            </div>
            <div class="layui-form-item">
                <label for="param" class="layui-form-label">
                    备注
                </label>
                <div class="layui-input-inline">
                    <textarea name="remark" lay-verify="remark" autocomplete="off" class="layui-textarea">{{ isset($data->remark) && $action ? $data->remark : ''}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="p_id" class="layui-form-label">
                    状态
                </label>
                <div class="layui-input-inline">
                    <select name="state">
                        <option value="0" @if(!empty($data->state) && $action && $data->state == 0) selected @endif >在左侧菜单显示</option>
                        <option value="1" @if(!empty($data->state) && $action && $data->state == 1) selected @endif >在左侧菜单隐藏</option>
                    </select>
                </div>
            </div>
            @if($action)
                <input type="hidden" name="id" value="{{$id}}">
                <input type="hidden" name="level" value="{{$data->level}}">
            @else
                <input type="hidden" name="level" value="{{empty($data) ? 1 : $data->level+1}}">
            @endif

            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
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
                $.post("{{url('admin/doSaveMenu')}}",data.field,function(result) {
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
            form.on('select(level)', function(data) {
                var level = $(data.elem).find("option:selected").attr("level_");
                $('input[name=level]').val(parseInt(level)+1);
            })

        });
    </script>
@endsection