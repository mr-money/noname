@extends('admin::admin.adminBase')

@section('title'){{request('id')==0?'添加菜单':'修改菜单'}}@endsection

@section('stylesheet')
    <link rel="stylesheet" href="/layuimini/lib/font-awesome-4.7.0/css/font-awesome.min.css" media="all">
    <link rel="stylesheet" href="/layuimini/js/lay-module/eleTree/eleTree.css" media="all">

    <style>
        .eleTree {
            border: 1px solid #ccc;
            overflow: hidden;
            display: inline-block;
        }

        .select-tree {
            height: 20px;
            width: 60%;
            display: none;
            position: absolute;
            top: 100%;
            background-color: #fff;
            z-index: 100;
        }

        .eleTree-loadData {
            top: -8px;
        }
    </style>
@endsection

@section('body')
    <div class="layuimini-container">
        <div class="layuimini-main">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">菜单名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" lay-verify="required" autocomplete="off"
                               value="{{empty($menu['title'])?'':$menu['title']}}"
                               placeholder="请输入菜单名称"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">父级菜单</label>
                    <div class="layui-input-block">
                        <input type="text" name="menu-tree" placeholder="选择父级菜单"
                               readonly="" autocomplete="off" class="layui-input" lay-verify="required"
                               style="cursor: default;"
                               value="{{empty($menu['parent']['title'])?'':$menu['parent']['title']}}">
                        <input type="hidden" name="pid" value="{{empty($menu['pid'])?'':$menu['pid']}}">
                        <div class="eleTree select-tree" id="menu-tree" lay-filter="menu-tree" style=""></div>
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
                               value="{{empty($menu['href'])?'':$menu['href']}}" placeholder="请输入菜单链接（父级菜单不跳转则不填）"
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
            const $ = layui.jquery,
                form = layui.form,
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
                    // console.log(data);
                },
                // 渲染成功后的回调
                success: function (d) {
                    // console.log(d);
                }
            });

            //渲染树形选择
            let ele;
            $("[name='menu-tree']").on("click", function (e) {
                e.stopPropagation();
                if (!ele) {
                    ele = eleTree.render({
                        elem: '#menu-tree',
                        accordion: true, // 是否每次只打开一个同级树节点展开（手风琴效果）
                        expandOnClickNode: false,
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
                        done: function () {
                            $(".select-tree").css('height', 'auto');
                        }
                    });
                }
                $("#menu-tree").toggle();
            })

            //树选中事件
            eleTree.on("nodeClick(menu-tree)", function (d) {
                var self_id = "{{request('id')}}";

                if(d.data.currentData.id == self_id){
                    layer.msg('父级菜单不能是自身', {icon: 2,});

                    return false;
                }

                //显示菜单名称
                $("[name='menu-tree']").val(d.data.currentData.title);
                //赋值菜单pid
                $("[name='pid']").val(d.data.currentData.id);
                $("#menu-tree").hide();

            });
            //点击外部隐藏
            $(document).on("click", function () {
                $("#menu-tree").hide();
            });

            //监听提交
            form.on('submit(menu-form)', function (data) {
                // console.log(JSON.stringify(data.field));
                var load = layer.load();

                data.field.id = "{{request('id')}}";
                data.field._token = "{!! csrf_token() !!}";
                $.post(
                    "{{url('api/admin/editMenuAjax')}}",
                    data.field,
                    function (result) {
                        layer.close(load);

                        // console.log(data);
                        if(result.code == 200){
                            layer.closeAll('iframe');
                            window.parent.location.reload();
                        }else{
                            layer.msg(result.msg, {
                                icon: 2,
                                time: 1500 //关闭（如果不配置，默认是3秒）
                            });
                        }

                    },
                    "json"
                );

                return false;
            });

        });
    </script>
@endsection
