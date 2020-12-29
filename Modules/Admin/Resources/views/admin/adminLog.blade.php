@extends('admin::admin.adminBase')

@section('title')登录日志@endsection

@section('stylesheet')
    <div class="layuimini-container">
        <div class="layuimini-main">
            <script type="text/html" id="topToolbar">
                <div class="layui-btn-container">
{{--                    <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"> 添加 </button>--}}
                    <button class="layui-btn layui-btn-sm layui-btn-danger data-delete-btn" lay-event="delete"> 删除 </button>
                </div>
            </script>

            <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

            <script type="text/html" id="currentTableBar">
{{--                <a class="layui-btn layui-btn-normal layui-btn-xs data-count-edit" lay-event="edit">编辑</a>--}}
                <a class="layui-btn layui-btn-xs layui-btn-danger data-count-delete" lay-event="delete">删除</a>
            </script>

        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['form', 'table'], function () {
            var $ = layui.jquery,
                form = layui.form,
                table = layui.table;

            table.render({
                elem: '#currentTableId',
                url: "{{url('api/admin/getAdminLogAjax')}}",
                toolbar: '#topToolbar',
                defaultToolbar: ['filter', 'exports', 'print', {
                    title: '提示',
                    layEvent: 'tips',
                    icon: 'layui-icon-tips'
                }],
                cols: [[
                    {type: "checkbox", width: 50},
                    {field: 'id', width: 80, title: 'ID', sort: true},
                    {field: "admin['nickname']", width: 80, title: '用户名'},
                    {title: '操作', minWidth: 150, toolbar: '#currentTableBar', align: "center"}
                ]],
                limits: [10, 15, 20, 25, 50, 100],
                limit: 2,
                page: true,
                skin: 'line'
            });

            /**
             * toolbar监听事件
             */
            table.on('toolbar(currentTableFilter)', function (obj) {
                console.log(obj.event);
                if (obj.event === 'add') {  // 监听添加操作
                    var index = layer.open({
                        title: '添加用户',
                        type: 2,
                        shade: 0.2,
                        maxmin:true,
                        shadeClose: true,
                        area: ['100%', '100%'],
                        content: '../page/table/add.html',
                    });
                    $(window).on("resize", function () {
                        layer.full(index);
                    });
                } else if (obj.event === 'delete') {  // 监听删除操作
                    var checkStatus = table.checkStatus('currentTableId')
                        , data = checkStatus.data;
                    layer.alert(JSON.stringify(data));
                }
            });

            //监听表格复选框选择
            table.on('checkbox(currentTableFilter)', function (obj) {
                console.log(obj)
            });

            table.on('tool(currentTableFilter)', function (obj) {
                var data = obj.data;
                if (obj.event === 'edit') {

                    var index = layer.open({
                        title: '编辑用户',
                        type: 2,
                        shade: 0.2,
                        maxmin:true,
                        shadeClose: true,
                        area: ['100%', '100%'],
                        content: '../page/table/edit.html',
                    });
                    $(window).on("resize", function () {
                        layer.full(index);
                    });
                    return false;
                } else if (obj.event === 'delete') {
                    layer.confirm('真的删除行么', function (index) {
                        obj.del();
                        layer.close(index);
                    });
                }
            });

        });
    </script>
@endsection