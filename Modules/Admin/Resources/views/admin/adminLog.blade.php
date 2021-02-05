@extends('admin::admin.adminBase')

@section('title')登录日志@endsection

@section('body')
    <div class="layuimini-container">
        <div class="layuimini-main">
            {{--<script type="text/html" id="topToolbar">
                <div class="layui-btn-container">
                    <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"> 添加 </button>
                    <button class="layui-btn layui-btn-sm layui-btn-danger data-delete-btn" lay-event="delete"> 删除 </button>
                </div>
            </script>--}}

            <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

            <script type="text/html" id="currentTableBar">
                {{--<a class="layui-btn layui-btn-normal layui-btn-xs data-count-edit" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-xs layui-btn-danger data-count-delete" lay-event="delete">删除</a>--}}
            </script>

        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['form', 'table'], function () {
            const $ = layui.jquery,
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
                    // {type: "checkbox", width: 50},
                    {field: 'id', minWidth: 80, title: 'ID', sort: true},
                    {field: "nickname", minWidth: 80, title: '昵称'},
                    {field: "account", minWidth: 80, title: '管理员账号'},
                    {field: "phone", minWidth: 80, title: '手机号'},
                    {field: "ip_adress", minWidth: 80, title: '登录ip'},
                    {
                        field: "created_at", minWidth: 80, title: '登录时间', sort: true,
                        templet: function (res) {
                            return layui.util.toDateString(res.created_at, "yyyy-MM-dd HH:mm:ss")
                        }
                    },
                    // {title: '操作', minWidth: 150, toolbar: '#currentTableBar', align: "center"}
                ]],
                limits: [10, 15, 20, 25, 50, 100],
                limit: 15,
                page: true,
                skin: 'line'
            });


            /*//toolbar监听事件
            table.on('toolbar(currentTableFilter)', function (obj) {
                if (obj.event === 'delete') {  // 监听删除操作
                    var checkStatus = table.checkStatus('currentTableId')
                        , data = checkStatus.data;
                    layer.alert(JSON.stringify(data));
                }
            });

            //监听表格复选框选择
            table.on('checkbox(currentTableFilter)', function (obj) {
                // console.log(obj)
            });

            table.on('tool(currentTableFilter)', function (obj) {
                var data = obj.data;
                // console.log(data);
                if (obj.event === 'delete') {
                    layer.confirm('真的删除行么', function (index) {
                        obj.del();
                        layer.close(index);
                    });
                }
            });*/

        });
    </script>
@endsection
