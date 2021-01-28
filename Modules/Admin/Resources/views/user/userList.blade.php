@extends('admin::admin.adminBase')

@section('title')用户管理@endsection

@section('stylesheet')
    <style>
        .layui-table-cell{
            text-align:center;
            height: auto;
            white-space: normal;
        }
        .layui-table img{
            max-width:62px
        }
    </style>
@endsection

@section('body')
    <div class="layuimini-container">
        <div class="layuimini-main">

            <fieldset class="table-search-fieldset">
                <legend>搜索信息</legend>
                <div style="margin: 10px 10px 10px 10px">
                    <form class="layui-form layui-form-pane" action="">
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">姓名</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="username" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">电话</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="sex" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <button type="submit" class="layui-btn layui-btn-normal" lay-submit
                                        lay-filter="data-search-btn"><i class="layui-icon"></i> 搜 索
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>

            <script type="text/html" id="toolbar">
                <div class="layui-btn-container">
                    {{--                    <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"> 添加 </button>--}}
                    <button class="layui-btn layui-btn-sm layui-btn-danger data-delete-btn" lay-event="delete"> 删除
                    </button>
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
        layui.use(['form', 'table'], function () {
            var $ = layui.jquery,
                form = layui.form,
                table = layui.table;

            table.render({
                elem: '#currentTableId',
                url: "{{url('api/user/getUserListAjax')}}",
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
                    {field: 'nickname',minWidth:80, title: '昵称'},
                    {field: 'username',width:80, title: '姓名'},
                    {field: 'phone',minWidth:80, title: '手机'},
                    {
                        field: 'avatar', width: 80, title: '头像',
                        templet: function (res) {
                            return "<img src='" + res.avatar + "'>";
                        }
                    },
                    {
                        field: 'sex', width: 80, title: '性别',
                        templet: function (res) {
                            return res.sex == 1?'男':'女';
                        }
                    },
                    {
                        field: "subscribe_time", minWidth: 80, title: '关注时间', sort: true,
                        templet: function (res) {
                            return layui.util.toDateString(res.subscribe_time*1000, "yyyy-MM-dd HH:mm:ss");
                        }
                    },
                    {title: '操作', minWidth: 100, toolbar: '#currentTableBar', align: "center"}
                ]],
                limits: [10, 15, 20, 25, 50, 100],
                limit: 15,
                page: true,
                skin: 'line'
            });

            // 监听搜索操作
            form.on('submit(data-search-btn)', function (data) {
                var result = JSON.stringify(data.field);
                layer.alert(result, {
                    title: '最终的搜索信息'
                });

                //执行搜索重载
                table.reload('currentTableId', {
                    page: {
                        curr: 1
                    }
                    , where: {
                        searchParams: result
                    }
                }, 'data');

                return false;
            });

            /**
             * toolbar监听事件
             */
            table.on('toolbar(currentTableFilter)', function (obj) {
                if (obj.event === 'delete') {  // 监听删除操作
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
                        maxmin: true,
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
