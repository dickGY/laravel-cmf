@extends('admin.admin')

@section('content')
    <div class="x-body">
        <xblock>
            {{--<button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>--}}
            <button class="layui-btn" onclick="x_admin_show('添加用户','{{url('admin/saveRole')}}','600','500')"><i class="layui-icon"></i>添加</button>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;" href="javascript:location.replace(location.href);" title="刷新">
                <i class="iconfont nav_right" style="line-height:30px">&#xe6aa;</i>
            </a>
            <span class="x-right" style="line-height:40px">共有数据：{{count($data)}} 条</span>
        </xblock>
        <table class="layui-table layui-form">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>角色名</th>
                    <th>状态</th>
                    <th>备注</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->id}}</td>
                        <td>{{$v->name}}</td>
                        <td>
                            @if($v->id != 1)
                                <input type="checkbox" id="{{$v->id}}" lay-text="启用|禁用" @if($v->state == 0) lay-skin="switch" checked="" @endif  lay-filter="state">
                            @else
                                启用
                            @endif
                        </td>
                        <td>{{$v->remark}}</td>
                        <td class="td-manage">
                            @if($v->id != 1)
                                <button type="button" onclick="x_admin_show('权限设置','{{url('admin/allot/'.$v->id)}}','800')" class="layui-btn layui-btn-warm layui-btn-xs" style="height: 20px;line-height: 20px;">权限设置</button>
                                <a title="编辑" onclick="x_admin_show('编辑','{{url('admin/saveRole/'.$v->id)}}','600','500')" href="javascript:;">
                                    <i class="layui-icon">&#xe642;</i>
                                </a>
                                <a title="删除" onclick="role_del(this,'{{$v->id}}')" href="javascript:;">
                                    <i class="layui-icon">&#xe640;</i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['form'], function(){
            form = layui.form;
            /*修改状态*/
            form.on('switch(state)',function (obj) {
                var state = obj.elem.checked ? 0 : 1;
                var id = obj.elem.id;
                $.post("{{url('admin/doSaveRole')}}",{state:state,id:id,_token: '{{csrf_token()}}',action:true},function(re){
                    layer.msg('状态更换成功!',{icon:1,time:1000});
                })
            })
        });


        /*删除*/
        function role_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                //发异步删除数据
                $.post("{{url('admin/doDeleRole')}}",{id:id,_token:'{{csrf_token()}}'},function (re) {
                    if(re.code == 0){
                        layer.msg(re.errors);
                    }else{
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    }
                },'json');
            });
        }

    </script>
@endsection