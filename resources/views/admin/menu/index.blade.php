@extends('admin.admin')

@section('script-src')
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <style>
        .layui-form-switch{width: 50px !important;}
    </style>
@endsection

@section('content')
    <div class="x-body">
        <xblock>
            <button class="layui-btn layui-btn-danger" onclick="rank()"><i class="layui-icon"></i>排序</button>
            <button class="layui-btn layui-btn-danger" onclick="x_admin_show('新增','{{url('admin/menu_add')}}','800')"><i class="layui-icon"></i>新增</button>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;" href="javascript:location.replace(location.href);" title="刷新">
                <i class="iconfont nav_right" style="line-height:30px">&#xe6aa;</i>
            </a>
        </xblock>
        <form id="rank">
            <table class="layui-table layui-form">
                <thead>
                <tr>
                    <th width="70">ID</th>
                    <th>栏目名</th>
                    <th width="50">排序</th>
                    <th width="50">状态</th>
                    <th width="250">操作</th>
                </thead>
                <tbody class="x-cate">
                @foreach($data as $v)
                    <tr cate-id='{{$v->id}}' fid='{{$v->p_id}}' >
                        <td>{{$v->id}}</td>
                        <td>
                            @if(!$v->getTree->isEmpty() && $v->level < 4)
                                @if($v->level != 1)
                                    @for($i=0;$i<(4*$v->level);$i++)
                                        &nbsp;
                                    @endfor
                                @endif
                                <i class="layui-icon x-show" status='true'>&#xe623;</i>
                            @elseif($v->getTree->isEmpty() || $v->level == 4)
                                @if($v->level != 1)
                                    @for($i=0;$i<(4*$v->level);$i++)
                                        &nbsp;
                                    @endfor
                                        |—
                                @endif
                            @endif
                            {{$v->name}}
                        </td>
                        <td>
                            <input type="text" class="layui-input x-sort" name="data[{{$v->id}}][sort]" value="{{$v->sort}}">
                            <input type="hidden" class="layui-input x-sort" name="data[{{$v->id}}][id]" value="{{$v->id}}">
                        </td>
                        <td>
                            <input type="checkbox" id="{{$v->id}}" lay-text="显示|隐藏" @if($v->state == 0) checked="" @endif lay-skin="switch" lay-filter="state">
                        </td>
                        <td class="td-manage">
                            <button type="button" class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','{{url('admin/menu_edit/'.$v->id.'/edit')}}','800')" ><i class="layui-icon">&#xe642;</i>编辑</button>
                            @if($v->level != 4)<button type="button" class="layui-btn layui-btn-warm layui-btn-xs"  onclick="x_admin_show('添加子栏目','{{url('admin/menu_add/'.$v->id)}}','800')" ><i class="layui-icon">&#xe642;</i>添加子栏目</button>@endif
                            <button type="button" class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,'{{$v->id}}')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="action" value="rank">
        </form>
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
                $.post("{{url('admin/doSaveMenu')}}",{state:state,id:id,_token: '{{csrf_token()}}',action:true},function(re){
                    layer.msg('状态更换成功!',{icon:1,time:1000});
                })
            })
        });

        /*用户-删除*/
        function member_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                //发异步删除数据
                $.post("{{url('admin/doDeleMenu')}}",{id:id,_token:'{{csrf_token()}}'},function (re) {
                    if(re.code == 0){
                        layer.msg(re.errors);
                    }else{
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    }
                },'json');
            });
        }

        /*整体排序*/
        rank = function () {
            var data = $('#rank').serialize();
            $.post("{{url('admin/doSaveMenu')}}",data,function(re){
                layer.msg('排序成功!',{icon:1,time:1000});
            })
        }
    </script>
@endsection