<!DOCTYPE html>
<html  class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title','Laravel-admin')</title>
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/static/css/font.css">
        <link rel="stylesheet" href="/static/css/xadmin.css">
        @yield('link-style')
        <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript"src="https://cdn.bootcss.com/blueimp-md5/2.10.0/js/md5.min.js"></script>
        <script src="/static/lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="/static/js/xadmin.js"></script>
        <script type="text/javascript" src="/static/js/cookie.js"></script>
        @yield('script-src')
    </head>
    <body class="@yield('body-class','')">
        {{--@section('nav')--}}
            {{--<div class="x-nav">--}}
                {{--<span class="layui-breadcrumb">--}}
                    {{--<a href="">首页</a>--}}
                    {{--<a><cite>导航元素</cite></a>--}}
                {{--</span>--}}
                {{--<a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">--}}
                    {{--<i class="layui-icon" style="line-height:30px">ဂ</i>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--@show--}}

        @yield('content')
    </body>
    <script>
        // console.log($('.layui-this').html());
    </script>
    @yield('script')
</html>