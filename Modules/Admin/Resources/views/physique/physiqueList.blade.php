@extends('admin::admin.adminBase')

@section('title')形象库管理@endsection

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
                <div class="layui-btn-container layui-form">
                    <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"> 添加</button>
                    <input type="checkbox" name="createUser" lay-filter="createUser" lay-skin="switch"
                           lay-text="用户|官方">
                    {{--<button class="layui-btn layui-btn-sm layui-btn-danger data-delete-btn" lay-event="delete"> 删除</button>--}}
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
        layui.use(['form', 'form', 'table'], function () {
            var $ = layui.jquery,
                form = layui.form,
                table = layui.table;

            table.render({
                elem: '#currentTableId',
                url: "{{url('api/physique/getPhysiqueAjax')}}",
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
                    {field: 'id', width: 80, title: 'ID', sort: true},
                    {field: 'physique_name', minWidth: 80, title: '形象库名称'},
                    {field: 'user_id', minWidth: 80, title: '创建用户'},
                    {field: 'remark', minWidth: 80, title: '形象描述'},
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

            //形象库创建人开关  开启用户，关闭管理员
            form.on('switch(createUser)', function (data) {
                console.log(data.elem); //得到checkbox原始DOM对象
                console.log(data.elem.checked); //开关是否开启，true或者false
                console.log(data.value); //开关value值，也可以通过data.elem.value得到
                console.log(data.othis); //得到美化后的DOM对象

                //开启用户开关
                if(data.elem.checked === true){
                    //重载列表

                }
            });

            /**
             * toolbar监听事件
             */
            table.on('toolbar(currentTableFilter)', function (obj) {
                if (obj.event === 'add') {  // 监听添加操作
                    const index = layer.open({
                        title: '添加官方形象库',
                        type: 2,
                        shade: 0.2,
                        maxmin: true,
                        shadeClose: true,
                        area: ['70%', '70%'],
                        content: "{{url('admin/physique/editPhysique/0')}}",
                    });
                    $(window).on("resize", function () {
                        layer.full(index);
                    });


                    //批量删除身体部位
                } else if (obj.event === 'delete') {  // 监听删除操作
                    const checkStatus = table.checkStatus('currentTableId'),
                        data = checkStatus.data;
                    let ids = [];
                    for (const value of data) {
                        ids.push(value.id);
                    }

                    if (ids.length === 0) {
                        return layer.msg('未选中选项', {'icon': 2});
                    }

                    layer.confirm('确认删除吗', function (index) { //确定
                        $.ajax({
                            url: "{{url('api/physique/delPhysiqueSetAjax')}}",
                            type: "DELETE",
                            data: {
                                ids: ids,
                                _token: "{!! csrf_token() !!}"
                            },
                            success: function (result) {
                                // 请求成功后的回调函数
                                // console.log(result);
                                if (result.code == 200) {
                                    layer.msg(result.msg, {'icon': 1}, table.reload('currentTableId'));
                                } else {
                                    layer.msg(result.msg, {'icon': 2});
                                }
                            }
                        });

                        layer.close(index);

                    });
                }

            });

            //按钮监听
            table.on('tool(currentTableFilter)', function (obj) {
                const data = obj.data;
                //编辑
                if (obj.event === 'edit') {
                    const index = layer.open({
                        title: '编辑部位设置',
                        type: 2,
                        shade: 0.2,
                        maxmin: true,
                        shadeClose: true,
                        area: ['70%', '70%'],
                        content: "{{url('admin/physique/editPhysiqueSet')}}/" + data.id,
                    });
                    $(window).on("resize", function () {
                        layer.full(index);
                    });

                } else if (obj.event === 'delete') { //删除
                    layer.confirm('确认删除吗', function (index) { //确定
                        $.ajax({
                            url: "{{url('api/physique/delPhysiqueSetAjax')}}",
                            type: "DELETE",
                            data: {
                                ids: [data.id],
                                _token: "{!! csrf_token() !!}"
                            },
                            success: function (result) {
                                // 请求成功后的回调函数
                                // console.log(result);
                                if (result.code == 200) {
                                    layer.msg(result.msg, {'icon': 1}, obj.del());
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
