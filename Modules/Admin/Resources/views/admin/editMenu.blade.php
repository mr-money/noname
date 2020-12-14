@extends('admin::admin.adminBase')

@section('title')菜单管理@endsection

@section('stylesheet')
    <link rel="stylesheet" href="/layuimini/lib/font-awesome-4.7.0/css/font-awesome.min.css" media="all">
    <link rel="stylesheet" href="/layuimini/js/lay-module/eleTree/eleTree.css" media="all">
@endsection

@section('body')
    <div class="layuimini-container">
        <div class="layuimini-main">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">菜单名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" lay-verify="title" autocomplete="off"
                               value="{{empty($menu['title'])?'':$menu['title']}}"
                               placeholder="请输入菜单名称"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">父级菜单</label>
                    <div class="layui-input-block">
                        <div class="eleTree" id="menu-tree" lay-filter="menu-tree"></div>
                        <input type="hidden" name="menu-tree">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">菜单图标</label>
                    <div class="layui-input-block">
                        <input type="text" name="icon" id="iconPicker"
                               value="{{empty($menu['icon'])?'fa-area-chart':$menu['icon']}}" lay-filter="iconPicker"
                               class="hide">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">链接</label>
                    <div class="layui-input-block">
                        <input type="text" name="href" autocomplete="off"
                               value="{{empty($menu['href'])?'':$menu['href']}}" placeholder="请输入链接"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-block">
                        <input type="text" name="sort" autocomplete="off"
                               value="{{empty($menu['sort'])?'0':$menu['sort']}}" placeholder="请输入序号 数字越大越靠前"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">打开方式</label>
                    <div class="layui-input-block">
                        <input type="radio" name="target" value="_self" title="_self"
                                {{empty($menu['target']) || $menu['target'] == '_self'?'checked':''}} >
                        <input type="radio" name="target" value="_blank" title="_blank"
                                {{!empty($menu['target']) && $menu['target'] == '_blank'?'checked':''}} >
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">备注信息</label>
                    <div class="layui-input-block">
                        <textarea name="remark" placeholder="请输入内容"
                                  class="layui-textarea">{{empty($menu['remark'])?'':$menu['remark']}}</textarea>
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
        layui.use(['form', 'iconPickerFa', 'eleTree'], function () {
            var form = layui.form,
                layer = layui.layer,
                iconPickerFa = layui.iconPickerFa,
                eleTree = layui.eleTree;

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
                    // console.log(d);
                }
            });


            //渲染树形选择
            eleTree.render({
                elem: '#menu-tree',
                // data: menudata,
                showRadio: true, // 是否显示radio
                accordion: true, // 是否每次只打开一个同级树节点展开（手风琴效果）
                highlightCurrent: true,

                method: "get",      // 接口http请求类型
                url: "{{url('api/admin/getMenuDirAjax')}}",            // 异步接口地址
                response: {         // 对后台返回的数据格式重新定义
                    statusName: "code",
                    statusCode: 200,
                    dataName: "data"
                },
                defaultPid: 0,     // 第一层pid的初始值
                request: {          // 对于后台数据重新定义名字
                    name: "title",
                    key: "id",
                    pid: "pid",
                    children: "child"
                },
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
