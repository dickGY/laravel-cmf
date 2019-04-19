@extends('admin.admin')

@section('nav')
@endsection

@section('content')
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="./index.html">laravel-cmf</a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        <ul class="layui-nav left fast-add" lay-filter="">
            <li class="layui-nav-item">
                <a href="javascript:;">+新增</a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a onclick="x_admin_show('资讯','https://www.baidu.com')"><i class="iconfont">&#xe6a2;</i>资讯</a></dd>
                    <dd><a onclick="x_admin_show('图片','https://www.baidu.com')"><i class="iconfont">&#xe6a8;</i>图片</a></dd>
                    <dd><a onclick="x_admin_show('用户 最大化','https://www.baidu.com','','',true)"><i class="iconfont">&#xe6b8;</i>用户最大化</a></dd>
                    <dd><a onclick="x_admin_add_to_tab('在tab打开','https://www.baidu.com',true)"><i class="iconfont">&#xe6b8;</i>在tab打开</a></dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav right" lay-filter="">
            <li class="layui-nav-item">
                <a href="javascript:;">{{$admin->user_nickname}}</a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a onclick="x_admin_show('个人信息','http://www.baidu.com')">个人信息</a></dd>
                    <dd><a onclick="x_admin_show('切换帐号','http://www.baidu.com')">切换帐号</a></dd>
                    <dd><a href="{{url('admin/outLogin')}}">退出</a></dd>
                </dl>
            </li>
        </ul>

    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
    <!-- 左侧菜单开始 -->
    <div class="left-nav">
        <div id="side-nav">
            <ul id="nav">
                @if(cmf_role_id() == 1)
                    <li  date-refresh="1">
                        <a _href="{{url('admin/menu')}}">
                            <i class="iconfont">&#xe699;</i>
                            <cite>菜单管理</cite>
                        </a>
                    </li>
                @endif
                @foreach($menu as $k=>$v)
                    <li @if(!$v->getTree->isEmpty()) date-refresh="1" @endif>
                        <a _href="@if(!$v->getTree->isEmpty()) javescript:; @else {{url($v->route)}} @endif">
                            <i class="iconfont">@if($v->icon) {!! $v->icon !!}  @else &#xe699; @endif</i>
                            <cite>{{$v->name}}</cite>
                            @if(!$v->getTree->isEmpty())<i class="iconfont nav_right">&#xe697;</i>@endif
                        </a>
                        @if(!$v->getTree->isEmpty())
                            <ul class="sub-menu">
                                @foreach($v->getTree as $kk=>$vv)
                                    <li @if(!$vv->getTree->isEmpty()) date-refresh="1" @endif>
                                        <a _href="@if(!$vv->getTree->isEmpty()) javescript:; @else {{url($vv->route)}} @endif">
                                            <i class="iconfont">@if($vv->icon) {!! $vv->icon !!}  @else &#xe699; @endif</i>
                                            <cite>{{$vv->name}}</cite>
                                            @if(!$vv->getTree->isEmpty())<i class="iconfont nav_right">&#xe697;</i>@endif
                                        </a>
                                        @if(!$vv->getTree->isEmpty())
                                            <ul class="sub-menu">
                                                @foreach($vv->getTree as $kkk=>$vvv)
                                                    <li>
                                                        <a _href="{{url($vvv->route)}}">
                                                            <cite>{{$vvv->name}}</cite>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
            <ul class="layui-tab-title">
                <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
            </ul>
            <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
                <dl>
                    <dd data-type="this">关闭当前</dd>
                    <dd data-type="other">关闭其它</dd>
                    <dd data-type="all">关闭全部</dd>
                </dl>
            </div>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <iframe src='{{url('admin/welcome')}}' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
                </div>
            </div>
            <div id="tab_show"></div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
    <div class="footer">
        <div class="copyright">Copyright ©2017 x-admin v2.3 All Rights Reserved</div>
    </div>
    <!-- 底部结束 -->
@endsection

@section('script')
    <script>

    </script>
@endsection