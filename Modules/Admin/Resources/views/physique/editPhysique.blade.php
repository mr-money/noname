@extends('admin::admin.adminBase')

@section('title'){{request('id')==0?'添加形象':'修改形象'}}@endsection

@section('body')
    <div class="layuimini-container">
        <div class="layuimini-main">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">*形象名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="physique_name" lay-verify="required" autocomplete="off"
                               value="{{empty($physique['physique_name'])?'':$physique['physique_name']}}" placeholder="请输形象名称"
                               class="layui-input">
                    </div>
                </div>

                @foreach($physique_set as $list)
                <div class="layui-form-item">
                    <label class="layui-form-label">*{{$list['part_name']}}</label>
                    <div class="layui-input-inline">
                        <input type="text" name="physique_value[{{$list['part_name']}}]" lay-verify="required" autocomplete="off"
                               value="{{empty($list['default_value'])?'':$list['default_value']}}" placeholder="请输入形象数据"
                               class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">{{$list['unit']}}</div>
                </div>
                @endforeach

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">*形象描述</label>
                    <div class="layui-input-block">
                        <textarea name="remark" placeholder="请输入形象描述 小于150字" lay-verify="required"
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
                    "{{url('api/physique/editPhysiqueAjax')}}",
                    data.field,
                    function (result) {
                        layer.close(load);

                        console.log(result);return;
                        if (result.code == 200) {
                            layer.msg(result.msg,{'icon':1},function (){
                                layer.closeAll('iframe');
                                window.parent.location.reload();
                            });

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
