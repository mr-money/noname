@extends('admin::admin.adminBase')

@section('title'){{request('id')==0?'添加部位':'修改部位'}}@endsection

@section('body')
    <div class="layuimini-container">
        <div class="layuimini-main">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">部位名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="part_name" lay-verify="required" autocomplete="off"
                               value="{{empty($physique['part_name'])?'':$physique['part_name']}}" placeholder="请输入部位名称"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">单位</label>
                    <div class="layui-input-block">
                        <input type="text" name="unit" autocomplete="off"
                               value="{{empty($physique['unit'])?'':$physique['unit']}}" placeholder="请输入单位"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">默认数据</label>
                    <div class="layui-input-block">
                        <input type="text" name="default_value" autocomplete="off"
                               value="{{empty($physique['default_value'])?'':$physique['default_value']}}" placeholder="请输入默认数据"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">部位描述</label>
                    <div class="layui-input-block">
                        <textarea name="remark" placeholder="请输入部位描述"
                                  class="layui-textarea">{{empty($physique['remark'])?'':$physique['remark']}}</textarea>
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
        layui.use(['form'], function () {
            const $ = layui.jquery,
                form = layui.form;


            //监听提交
            form.on('submit(menu-form)', function (data) {
                // console.log(JSON.stringify(data.field));
                const load = layer.load();

                data.field.id = "{{request('id')}}";
                data.field._token = "{!! csrf_token() !!}";

                $.post(
                    "{{url('api/physique/editPhysiqueSetAjax')}}",
                    data.field,
                    function (result) {
                        layer.close(load);

                        // console.log(data);return;
                        if (result.code == 200) {
                            layer.closeAll('iframe');
                            window.parent.location.reload();
                        } else {
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
