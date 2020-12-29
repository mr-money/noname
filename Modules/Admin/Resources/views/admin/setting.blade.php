@extends('admin::admin.adminBase')

@section('title')系统设置@endsection

@section('stylesheet')
    <style>
        .layui-form-item .layui-input-company {
            width: auto;
            padding-right: 10px;
            line-height: 38px;
        }
    </style>
@endsection

@section('body')
    <div class="layuimini-container">
        <div class="layuimini-main">

            <div class="layui-form layuimini-form">
                <div class="layui-form-item">
                    <label class="layui-form-label required">网站名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="sitename" lay-verify="required" lay-reqtext="网站名称不能为空"
                               placeholder="请输入网站名称" value="{{empty($setting['sitename'])?'':$setting['sitename']}}"
                               class="layui-input">
                        <tip>填写自己部署网站的名称。</tip>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label required">网站域名</label>
                    <div class="layui-input-block">
                        <input type="text" name="domain" lay-verify="required" lay-reqtext="网站域名不能为空"
                               placeholder="请输入网站域名"
                               value="{{empty($setting['domain'])?'':$setting['domain']}}" class="layui-input">
                    </div>
                </div>

                {{--<div class="layui-form-item">
                    <label class="layui-form-label">最大文件上传</label>
                    <div class="layui-input-inline" style="width: 80px;">
                        <input type="text" name="cache" lay-verify="number" value="2048" class="layui-input">
                    </div>
                    <div class="layui-input-inline layui-input-company">KB</div>
                    <div class="layui-form-mid layui-word-aux">提示：1 M = 1024 KB</div>
                </div>--}}

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label required">首页标题</label>
                    <div class="layui-input-block">
                        <textarea name="title" class="layui-textarea"
                                  lay-verify="required">{{empty($setting['title'])?'':$setting['title']}}</textarea>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">META关键词</label>
                    <div class="layui-input-block">
                        <textarea name="keywords" class="layui-textarea"
                                  placeholder="多个关键词用英文状态 ; 号分割">{{empty($setting['keywords'])?'':$setting['keywords']}}</textarea>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">META描述</label>
                    <div class="layui-input-block">
                        <textarea name="descript"
                                  class="layui-textarea">{{empty($setting['descript'])?'':$setting['descript']}}</textarea>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label required">版权信息</label>
                    <div class="layui-input-block">
                        <textarea name="copyright"
                                  class="layui-textarea"
                                  lay-verify="required">{{empty($setting['copyright'])?'':$setting['copyright']}}</textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="hidden" name="id" value="{{empty($setting['id'])?'':$setting['id']}}">
                        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="setting">确认保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['form'], function () {
            const $ = layui.jquery,
                form = layui.form;

            //监听提交
            form.on('submit(setting)', function (data) {
                // console.log(data.field);
                // console.log(JSON.stringify(data.field));
                data.field._token = "{!! csrf_token() !!}";
                $.post(
                    "{{url('api/admin/editSettingAjax')}}",
                    data.field,
                    function (result) {
                        if(result.code == 200){
                            layer.msg(result.msg,{'icon':1});
                        }else{
                            layer.msg(result.msg, {'icon': 2});
                        }
                    },
                    "json"
                );
            });

        });
    </script>
@endsection
