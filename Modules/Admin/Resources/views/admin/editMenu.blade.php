@extends('admin::admin.adminBase')

@section('title')菜单管理@endsection

@section('stylesheet')
    <link rel="stylesheet" href="/layuimini/lib/font-awesome-4.7.0/css/font-awesome.min.css" media="all">
@endsection

@section('body')
    <div class="layuimini-container">
        <div class="layuimini-main">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">菜单名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入菜单名称"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">菜单图标</label>
                    <div class="layui-input-block">
                        <input type="text" name="icon" id="iconPicker" value="fa-area-chart" lay-filter="iconPicker" class="hide">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">链接</label>
                    <div class="layui-input-block">
                        <input type="text" name="href" autocomplete="off" placeholder="请输入链接"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-block">
                        <input type="text" name="sort" autocomplete="off" value="0" placeholder="请输入序号 数字越大越靠前"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">打开方式</label>
                    <div class="layui-input-block">
                        <input type="radio" name="target" value="_self" title="本窗口" checked>
                        <input type="radio" name="target" value="_blank" title="新窗口">
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">备注信息</label>
                    <div class="layui-input-block">
                        <textarea name="remark" placeholder="请输入内容" class="layui-textarea"></textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit="" lay-filter="menu-form">立即提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['form', 'layedit', 'laydate', 'iconPickerFa'], function () {
            var form = layui.form,
                layer = layui.layer,
                layedit = layui.layedit,
                laydate = layui.laydate,
                iconPickerFa = layui.iconPickerFa;

            //图标选择器
            iconPickerFa.render({
                // 选择器，推荐使用input
                elem: '#iconPicker',
                // fa 图标接口
                url: "/layuimini/lib/font-awesome-4.7.0/less/variables.less",
                // 是否开启搜索：true/false，默认true
                search: true,
                // 是否开启分页：true/false，默认true
                page: true,
                // 每页显示数量
                limit: 20,
                // 点击回调
                click: function (data) {
                    console.log(data);
                },
                // 渲染成功后的回调
                success: function (d) {
                    console.log(d);
                }
            });


            //监听提交
            form.on('submit(menu-form)', function (data) {
                console.log(data.field);
                layer.alert(JSON.stringify(data.field), {
                    title: '最终的提交信息'
                })
                return false;
            });
        });
    </script>
@endsection
