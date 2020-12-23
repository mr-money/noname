@extends('admin::admin.adminBase')

@section('title')账号管理@endsection

@section('body')
    <div class="layuimini-container">
        <div class="layuimini-main">

            <div class="layui-form layuimini-form">
                <div class="layui-form-item">
                    <label class="layui-form-label required">管理员账号</label>
                    <div class="layui-input-block">
                        <input type="text" name="username" lay-verify="required" lay-reqtext="管理员账号不能为空"
                               readonly value="{{session('admin.account')}}" class="layui-input">
                        <tip>管理员账号不能修改</tip>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label required">管理员昵称</label>
                    <div class="layui-input-block">
                        <input type="text" name="username" lay-verify="required" lay-reqtext="管理员昵称不能为空"
                               placeholder="请输入管理账号" value="{{session('admin.nickname')}}" class="layui-input">
                        <tip>填写自己管理员昵称的名称。</tip>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label required">手机</label>
                    <div class="layui-input-block">
                        <input type="number" name="phone" lay-verify="required" lay-reqtext="手机不能为空" placeholder="请输入手机"
                               value="" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label required">旧密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="old_password" lay-verify="required" lay-reqtext="旧密码不能为空"
                               placeholder="请输入旧密码" value="**********" class="layui-input">
                        <tip>填写自己账号的旧的密码。</tip>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">新密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="password" lay-verify="pwd" placeholder="请输入新密码" value=""
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">确认新密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="again_password" lay-verify="pwd" placeholder="请确认输入新密码"
                               value="" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn">确认保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['form', 'miniTab'], function () {
            const $ = layui.jquery,
                form = layui.form;

            //表单验证
            form.verify({
                //修改密码验证
                pwd: function (value, item) {
                    const password =  $("[name='password']").val();
                    const again_password =  $("[name='again_password']").val();

                    if(password != '' && again_password != ''){
                        if(password != again_password){
                            return '密码确认错误';
                        }

                        //TODO 验证旧密码
                        $.post(
                            "url",
                            {
                                data:data,
                            },
                            function(result){
                                console.log(result);
                            },
                            "json"
                        );
                    }
                }
            });

            //监听提交
            form.on('submit(setting)', function (data) {
                // console.log(data.field);
                // console.log(JSON.stringify(data.field));
                data.field._token = "{!! csrf_token() !!}";
                $.post(
                    "url",
                    data.field,
                    function (result) {
                        if (result.code == 200) {
                            layer.msg(result.msg, {'icon': 1});
                        } else {
                            layer.msg(result.msg, {'icon': 2, time: 1500});
                        }
                    },
                    "json"
                );
            });

        });
    </script>
@endsection
