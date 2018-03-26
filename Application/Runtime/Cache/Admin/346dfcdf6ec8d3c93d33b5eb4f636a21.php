<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>后台管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="/Public/Admin/css/main.css" rel="stylesheet" type="text/css"/>
    <link href="/Public/Admin/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/Public/Admin/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
    <script src="/Public/Admin/js/jquery-1.8.1.min.js"></script>
    <script src="/Public/Admin/js/bootstrap.min.js"></script>
    
</head>
<body>
    <!-- 上 -->
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
                <ul class="nav pull-right">
                    <li id="fat-menu" class="dropdown">
                        <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user icon-white"></i> admin
                            <i class="icon-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="javascript:void(0);">修改密码</a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" href="/index.php/Admin/Login/logout.html">安全退出</a></li>
                        </ul>
                    </li>
                </ul>
                <a class="brand" href="index.html"><span class="first">后台管理系统</span></a>
                <ul class="nav">
                    <li class="active"><a href="javascript:void(0);">首页</a></li>
                    <li><a href="javascript:void(0);">系统管理</a></li>
                    <li><a href="javascript:void(0);">权限管理</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- 左 -->
    <div class="sidebar-nav">
        <?php if(is_array($_SESSION['top'])): $k = 0; $__LIST__ = $_SESSION['top'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><a href="#error-menu<?php echo ($k); ?>" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i><?php echo ($v["auth_name"]); ?></a>
        <ul id="error-menu<?php echo ($k); ?>" class="nav nav-list collapse in">
            <?php if(is_array($_SESSION['second'])): $key = 0; $__LIST__ = $_SESSION['second'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol_second): $mod = ($key % 2 );++$key; if($vol_second["pid"] == $v["id"] ): ?><li><a href="/index.php/Admin/<?php echo ($vol_second["auth_c"]); ?>/<?php echo ($vol_second["auth_a"]); ?>.html"><?php echo ($vol_second["auth_name"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </ul><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
<script type="text/javascript" src="/Public/Admin/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/Admin/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/Public/Admin/ueditor/lang/zh-cn/zh-cn.js"></script>
    <!-- 右 -->
    <div class="content">
        <div class="header">
            <h1 class="page-title">商品新增</h1>
        </div>

        <!-- add form -->
        <form action="" method="post" id="tab" enctype="multipart/form-data">
            <ul class="nav nav-tabs">
              <li role="presentation" class="active"><a href="#basic" data-toggle="tab">基本信息</a></li>
              <li role="presentation"><a href="#desc" data-toggle="tab">商品描述</a></li>
              <li role="presentation"><a href="#attr" data-toggle="tab">商品属性</a></li>
              <li role="presentation"><a href="#pics" data-toggle="tab">商品相册</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="basic">
                    <div class="well">
                        <label>商品名称：</label>
                        <input type="text" name="name" value="" class="input-xlarge">
                        <label>商品价格：</label>
                        <input type="text" name="price" value="" class="input-xlarge">
                        <label>商品数量：</label>
                        <input type="text" name="number" value="" class="input-xlarge">
                        <label>商品logo：</label>
                        <input type="file" name="logo" value="" class="input-xlarge">
                        <label>商品分类：</label>
                        <select name="cate_id" class="input-xlarge">
                            <option value="0">===请选择===</option>
                            <?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["cate_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="tab-pane fade in" id="desc">
                    <div class="well">
                        <label>商品简介：</label>
                        <textarea id="editor" value="Smith" name="introduce" rows="3" class="input-xlarge" style="width:1024px;height:500px;"></textarea>
                    </div>
                </div>
                <div class="tab-pane fade in" id="attr">
                    <div class="well">
                        <label>商品类型：</label>
                        <select name="type_id" class="input-xlarge">
                            <option value="0">==请选择==</option>
                            <?php if(is_array($type)): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["type_id"]); ?>"><?php echo ($v["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                       <div id="attrs">
                           
                       </div>
                    </div>
                </div>
                <div class="tab-pane fade in" id="pics">
                    <div class="well">
                        <div>[<a href="javascript:void(0);" class="add">+</a>]商品图片：<input type="file" name="goods_pics[]" value="" class="input-xlarge"></div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">保存</button>
            </div>
        </form>
        <!-- footer -->
        <footer>
            <hr>
            <p>© 2017 <a href="javascript:void(0);" target="_blank">ADMIN</a></p>
        </footer>
    </div>
    <script type="text/javascript">
     
        $(function(){
            //实例化编辑器
           var ue = UE.getEditor('editor');

            $('.add').click(function(){
                var add_div = '<div>[<a href="javascript:void(0);" class="sub">-</a>]商品图片：<input type="file" name="goods_pics[]" value="" class="input-xlarge"></div>';
                $(this).parent().after(add_div);
            });
            $('.sub').live('click',function(){
                $(this).parent().remove();
            });

            //给下拉列表绑定change事件
            $('select[name=type_id]').change(function(){
                // alert(1);
                var type_id = $(this).val();
                // alert(type_id);return;
                $.ajax({
                    'url':'/index.php/Admin/Goods/getattr',
                    'type':'post',
                    'data':'type_id='+type_id,
                    'dataType':'json',
                    'success':function(response){
                        if(response.code!=10000){
                            // alert(1);return;
                            alert(response.msg);
                        }else{
                            //获取所有的属性信息
                            var attrs = response.data;
                            //遍历拼接html代码字符串
                            var str = '';
                            $.each(attrs,function(i,v){
                                //console.log(v);
                                //拼接属性名称的显示HTML代码
                                str +="<label>" + v.attr_name + ": </label>";
                                if(v.attr_input_type == 0){
                                    //录入方式为input输入框
                                    str +="<input type='text' name='attr_value["+v.attr_id+"][]' value='' class='input-xlarge'>"
                                }else if(v.attr_input_type == 1){
                                    //录入方式为下拉列表
                                    str +="<select name='attr_value["+v.attr_id+"][]' class='input-xlarge'>";
                                    $.each(v.attr_values,function(index,value){
                                         str +="<option value='"+value+"'>"+value+"</option>";
                                    })
                                   
                                    str +="</select>";
                                }else{
                                    //多选框
                                    $.each(v.attr_values,function(index,value){
                                        str +="<input type='checkbox' name='attr_value["+v.attr_id+"][]' value='"+ value +"'>" + value;
                                    });
                                }
                            });

                            $('#attrs').html(str);
                        }
                    }
                });
            })
        });
    </script>



</body>
</html>