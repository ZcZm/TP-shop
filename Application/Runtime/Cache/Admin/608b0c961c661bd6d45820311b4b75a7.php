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
            <h1 class="page-title">商品编辑</h1>
        </div>
        
        <!-- edit form -->
        <form action="" method="post" id="tab" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo ($goods["id"]); ?>">
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
                        <input type="text" name="name" value="<?php echo ($goods["goods_name"]); ?>" class="input-xlarge">
                        <label>商品价格：</label>
                        <input type="text" name="price" value="<?php echo ($goods["goods_price"]); ?>" class="input-xlarge">
                        <label>商品数量：</label>
                        <input type="text" name="number" value="<?php echo ($goods["goods_number"]); ?>" class="input-xlarge">
                        <label>商品logo：</label>
                        <input type="file" name="logo" value="" class="input-xlarge">
                        <img src="<?php echo ($goods["goods_logo"]); ?>">
                    </div>
                </div>
                <div class="tab-pane fade in" id="desc">
                    <div class="well">
                        <label>商品简介：</label>
                        <textarea id="editor" value="Smith" name="introduce" rows="3" class="input-xlarge" style="width:1024px;height:500px;">qweqwe</textarea>
                    </div>
                </div>
                <div class="tab-pane fade in" id="attr">
                    <div class="well">
                        <label>商品分类：</label>
                        <select name="" class="input-xlarge">
                            <option value="2">电脑</option>
                            <option value="1">手机</option>
                        </select>
                        <div>
                            <label>商品品牌：</label>
                            <input type="text" name="" value="edit" class="input-xlarge">
                            <label>商品型号：</label>
                            <input type="text" name="" value="edit" class="input-xlarge">
                            <label>商品重量：</label>
                            <input type="text" name="" value="edit" class="input-xlarge">
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade in" id="pics">
                <div class="well">
                    <?php if(is_array($goodspics)): foreach($goodspics as $k=>$v): ?><div>
                        <img src="<?php echo ($v["pics_mid"]); ?>">[<a pics_id="<?php echo ($v["id"]); ?>" href="javascript:void(0);" class="delpics">-</a>]
                    </div><?php endforeach; endif; ?>
                </div>
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
        });

        //异步删除
        $('.delpics').click(function(){
            var _this = this;
            $.ajax({
                'url':'/index.php/Admin/Goods/delpics',
                'type':'post',
                'data':'pics_id=' + $(_this).attr('pics_id'),
                'dataType':'json',
                'success':function(response){
                    if(response.code != 10000){
                        alert(response.msg);
                    }else{
                        $(_this).parent().remove();
                    }
                }

            });
        });
    </script>



</body>
</html>