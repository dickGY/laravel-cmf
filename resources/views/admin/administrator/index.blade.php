@extends('admin.admin')

@section('content')
    <div class="x-body">
        <div class="layui-row">
            <form action="{{url('admin/administrator')}}" method="post" class="layui-form layui-col-md12 x-so">
                {{csrf_field()}}
                <input type="text" name="param[bName]" value="{{!empty($param['bName']) ? $param['bName'] : ''}}" placeholder="请输入用户名/手机号码/邮箱" class="layui-input" style="width: 300px;">
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </form>
        </div>
        <xblock>
            {{--<button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>--}}
            <button class="layui-btn" onclick="x_admin_show('添加管理员','{{url('admin/saveAdministrator')}}','800','550')"><i class="layui-icon"></i>添加</button>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;" href="javascript:location.replace(location.href);" title="刷新">
                <i class="iconfont nav_right" style="line-height:30px">&#xe6aa;</i>
            </a>
            <span class="x-right" style="line-height:40px">共有数据：{{$data->total()}} 条</span>
        </xblock>
        <table class="layui-table layui-form">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>手机</th>
                    <th>邮箱</th>
                    <th>角色</th>
                    <th>注册时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->id}}</td>
                        <td>{{$v->user_nickname}}</td>
                        <td>{{$v->mobile}}</td>
                        <td>{{$v->email}}</td>
                        <td>{{$v->getRole->name}}</td>
                        <td>{{$v->create_time}}</td>
                        <td>
                            <input type="checkbox" id="{{$v->id}}" lay-text="启用|禁止" @if($v->user_status == 1) checked="" @endif lay-skin="switch" lay-filter="state">
                        </td>
                        <td class="td-manage">
                            <a title="编辑"  onclick="x_admin_show('编辑','{{url('admin/saveAdministrator/'.$v->id)}}','800','400')" href="javascript:;">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="page">
            {{$data->appends(['param' => $param])->render()}}
        </div>

    </div>
@endsection

@section('script')
    <script>
        layui.use(['form'], function(){
            form = layui.form;
            /*修改状态*/
            form.on('switch(state)',function (obj) {
                var user_status = obj.elem.checked ? 1 : 0;
                var id = obj.elem.id;
                $.post("{{url('admin/doSaveAdministrator')}}",{user_status:user_status,id:id,_token: '{{csrf_token()}}',action:true},function(re){
                    layer.msg('状态更换成功!',{icon:1,time:1000});
                })
            })
        });
    </script>
@endsection