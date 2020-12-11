@extends('admin::admin.adminBase')

@section('title')菜单管理@endsection

@section('body')
    <div class="layuimini-container">
        <div class="layuimini-main">
            <div>
                <div class="layui-btn-group">
                    {{--<button class="layui-btn" id="btn-expand">全部展开</button>
                    <button class="layui-btn layui-btn-normal" id="btn-fold">全部折叠</button>--}}
                    <button class="layui-btn layui-btn-normal">添加</button>
                </div>
                <table id="munu-table" class="layui-table" lay-filter="munu-table"></table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- 操作列 -->
    <script type="text/html" id="auth-state">
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">修改</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>

    <script>
        layui.use(['layer', 'table', 'treetable'], function () {
            var $ = layui.jquery,
                layer = layui.layer,
                table = layui.table,
                treetable = layui.treetable;


            // 渲染表格
            var renderTable = function () {
                layer.load(2);
                treetable.render({
                    treeColIndex: 1,
                    treeSpid: 0, //最上级的父级id
                    treeIdName: 'id', //id字段的名称
                    treePidName: 'pid', //父级节点字段
                    elem: '#munu-table',
                    // url: '/layuimini/api/menus.json',
                    url: "{{url('api/admin/getMenuListAjax')}}",
                    page: false,
                    cols: [[
                        {type: 'numbers'},
                        {field: 'title', minWidth: 200, title: '名称'},
                        {field: 'href', title: '链接'},
                        {field: 'target', title: '打开方式'},
                        {field: 'sort', width: 80, align: 'center', title: '排序'},
                        {
                            field: 'status', width: 80, align: 'center', templet: function (d) {
                                if (d.status == 1) {
                                    return '<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="disable">禁用</a>';
                                } else {
                                    return '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="enable">启用</a>';
                                }
                            }, title: '状态'
                        },
                        {templet: '#auth-state', width: 120, align: 'center', title: '操作'}
                    ]],
                    done: function () {
                        layer.closeAll('loading');
                    }
                });
            }
            renderTable();


            //全部折叠展开
            /*$('#btn-expand').click(function () {
                treetable.expandAll('#munu-table');
            });

            $('#btn-fold').click(function () {
                treetable.foldAll('#munu-table');
            });*/

            //监听工具条
            table.on('tool(munu-table)', function (obj) {
                var data = obj.data;
                var layEvent = obj.event;


                if (layEvent === 'del') {
                    layer.msg('删除' + data.id);
                } else if (layEvent === 'edit') {
                    layer.msg('修改' + data.id);
                } else if (layEvent === 'disable' || layEvent === 'enable') {
                    //状态取反
                    var changeStatus = data.status == 1 ? 0 : 1;

                    //菜单状态修改
                    $.post(
                        "{{url('api/admin/changeMenuStateAjax')}}/" + data.id + '/' + changeStatus,
                        {
                            _token: "{!! csrf_token() !!}"
                        },
                        function (result) {
                            console.log(result);
                            if (result.code == 200) {
                                // layer.msg(result.msg);
                                renderTable();
                            } else {
                                layer.msg(result.msg);
                            }
                        }
                    );
                }
            });

        });
    </script>
@endsection
