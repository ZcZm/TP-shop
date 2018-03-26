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

    <!-- 右 -->
    <div class="content">
        <div class="header">
            <h1 class="page-title">商品属性新增</h1>
        </div>

        <div class="well">
            <!-- edit form -->
            <form id="tab" action="" method="post">
                <label>属性名称：</label>
                <input type="text" name="attr_name" value="" class="input-xlarge">
                <label>商品类型：</label>
                <select name="type_id" class="dfinput">
                    <option value="0">--请选择--</option>
                    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["type_id"]); ?>"><?php echo ($vol["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                <label>属性类型：</label>
                <input type="radio" name="attr_type" value="0" checked="checked">唯一属性&emsp;
                <input type="radio" name="attr_type" value="1">單選屬性
                <label>录入方式：</label>
                <input type="radio" name="attr_input_type" value="0" checked="checked">输入框&emsp;
                <input type="radio" name="attr_input_type" value="1">下拉列表
                <input type="radio" name="attr_input_type" value="2">多选框
               
                <label>可选值：</label>
                <textarea name="attr_values" placeholder="请输入可选值，多个值之间请使用英文“,”分隔开" class="textinput"></textarea>
                <label></label>
                <button class="btn btn-primary" type="submit">保存</button>
            </form>
        </div>
        <!-- footer -->
        <footer>
            <hr>
            <p>© 2017 <a href="javascript:void(0);" target="_blank">ADMIN</a></p>
        </footer>
    </div>



</body>
</html>