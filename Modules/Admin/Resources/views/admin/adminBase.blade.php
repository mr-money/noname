<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/layuimini/lib/layui-v2.5.5/css/layui.css" media="all">
    <link rel="stylesheet" href="/layuimini/css/public.css" media="all">
    @yield('stylesheet')
    <style>
        .layui-btn:not(.layui-btn-lg ):not(.layui-btn-sm):not(.layui-btn-xs) {
            height: 34px;
            line-height: 34px;
            padding: 0 8px;
        }
    </style>
</head>
<body>
    @yield('body')
</body>
</html>
<script src="/layuimini/lib/layui-v2.5.5/layui.js" charset="utf-8"></script>
<script src="/layuimini/js/lay-config.js?v=1.0.4" charset="utf-8"></script>

@yield('script')