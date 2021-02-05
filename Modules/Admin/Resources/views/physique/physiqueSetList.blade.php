@extends('admin::admin.adminBase')

@section('title')身体部位管理@endsection

@section('stylesheet')
    <style>
        .layui-table-cell {
            text-align: center;
            height: auto;
            white-space: normal;
        }

        .layui-table img {
            max-width: 62px
        }
    </style>
@endsection

@section('body')
    <div class="layuimini-container">
        <div class="layuimini-main">

            <script type="text/html" id="toolbar">
                <div class="layui-btn-container">
                    <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"> 添加</button>
                    <button class="layui-btn layui-btn-sm layui-btn-danger data-delete-btn" lay-event="delete"> 删除</button>
                </div>
            </script>

            <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

            <script type="text/html" id="currentTableBar">
                <a class="layui-btn layui-btn-normal layui-btn-xs data-count-edit" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-xs layui-btn-danger data-count-delete" lay-event="delete">删除</a>
            </script>

        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['form', 'table', 'laydate'], function () {
            var $ = layui.jquery,
                form = layui.form,
                laydate = layui.laydate,
                table = layui.table;

            //日期
            laydate.render({
                elem: '#start_time'
            });
            laydate.render({
                elem: '#end_time'
            });

            table.render({
                elem: '#currentTableId',
                url: "{{url('api/physique/getPhysiqueSetAjax')}}",
                toolbar: '#toolbar',
                defaultToolbar: ['filter', 'exports', 'print', {
                    title: '提示',
                    layEvent: 'LAYTABLE_TIPS',
                    icon: 'layui-icon-tips'
                }],
                parseData: function (res) { //res 即为原始返回的数据
                    return {
                        "code": res.code, //解析接口状态
                        "msg": res.msg, //解析提示文本
                        "count": res.data.count, //解析数据长度
                        "data": res.data.data, //解析数据列表
                    };
                },
                response: {
                    statusCode: 200 //规定成功的状态码，默认：0
                },
                cols: [[
                    {type: "checkbox", width: 50},
                    {field: 'id', width: 80, title: 'ID', sort: true},
                    {field: 'part_name', minWidth: 80, title: '部位名称'},
                    {field: 'unit', minWidth: 80, title: '单位'},
                    {field: 'default_value', minWidth: 80, title: '默认数据'},
                    {
                        field: "created_at", minWidth: 80, title: '创建时间', sort: true,
                        templet: function (res) {
                            return layui.util.toDateString(res.created_at, "yyyy-MM-dd HH:mm:ss");
                        }
                    },
                    {title: '操作', minWidth: 100, toolbar: '#currentTableBar', align: "center"}
                ]],
                limits: [10, 15, 20, 25, 50, 100],
                limit: 15,
                page: true,
                skin: 'line'
            });

            /**
             * toolbar监听事件
             */
            table.on('toolbar(currentTableFilter)', function (obj) {
                if (obj.event === 'add') {  // 监听添加操作
                    const index = layer.open({
                        title: '添加部位设置',
                        type: 2,
                        shade: 0.2,
                        maxmin:true,
                        shadeClose: true,
                        area: ['70%', '70%'],
                        content: "{{url('admin/physique/editPhysiqueSet/0')}}",
                    });
                    $(window).on("resize", function () {
                        layer.full(index);
                    });
                } else if (obj.event === 'delete') {  // 监听删除操作
                    const checkStatus = table.checkStatus('currentTableId')
                        , data = checkStatus.data;
                    console.log('111');
                    console.log(data);
                }

            });

            //按钮监听
            table.on('tool(currentTableFilter)', function (obj) {
                const data = obj.data;
                console.log('222');
                console.log(data);
                return;
                if (obj.event === 'delete') {
                    layer.confirm('确认删除吗', function (index) { //确定
                        $.ajax({
                            url:"{{url('api/admin/delMenuAjax')}}/" + data.id,
                            type:"DELETE",
                            data:{
                                _token: "{!! csrf_token() !!}"
                            },
                            success:function (result) {
                                // 请求成功后的回调函数
                                // console.log(result);return;
                                if (result.code == 200) {
                                    // layer.msg(result.msg);
                                    renderTable();
                                } else {
                                    layer.msg(result.msg, {'icon': 2});
                                }
                            }
                        });

                        layer.close(index);

                    });
                }
            });

        });
    </script>
@endsection
