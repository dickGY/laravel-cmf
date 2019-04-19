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
        <form id="rank"  class="layui-form">
            {{csrf_field()}}
            <table class="layui-table layui-form">
                <tbody class="x-cate">
                    @foreach($menu as $v)
                        <tr cate-id='{{$v->id}}' fid='{{$v->p_id}}' >
                            <td>
                                <input type="checkbox"
                                       lay-filter="menu"
                                       name="rule_route[]"
                                       lay-skin="primary"
                                       value="{{$v->route}}"
                                       @if(in_array($v->route,$accessRoute)) checked @endif
                                >
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <input type="hidden" name="role_id" value="{{$role_id}}">
            <button type="button" class="layui-btn layui-btn-warm layui-btn-xs" lay-filter="add" lay-submit="">
                <i class="layui-icon">&#xe642;</i>保存
            </button>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;" href="javascript:location.replace(location.href);" title="刷新">
                <i class="iconfont nav_right" style="line-height:30px">&#xe6aa;</i>
            </a>
        </form>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
            var form = layui.form
                ,layer = layui.layer;
            //这里的 menu　就是 HTML上面的lay-filter值，就固定一个值就好
            form.on('checkbox(menu)', function(data){
                var cate_id = $(data.elem).parents('tr').attr('cate-id');
                var fid = $(data.elem).parents('tr').attr('fid');
                // //这里实现勾选
                $('tr').each(function(index, item){
                    if(($(item).attr('cate-id') == fid && data.elem.checked)|| $(item).attr('fid') == cate_id){
                        $(item).find('input[type=checkbox]').prop("checked",data.elem.checked);
                    }
                });
                form.render('checkbox');
            });
            //监听提交
            form.on('submit(add)', function(data){
                console.log(data.field);
                $.post("{{url('admin/doAllot')}}",data.field,function(result) {
                    console.log(result);
                    if(result.code != 1){
                        layer.msg(result.errors, {icon: 2});
                    }else{
                        layer.alert("保存成功", {icon: 6},function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                        });
                    }
                },'json');
                return false;
            });
        });
    </script>
@endsection