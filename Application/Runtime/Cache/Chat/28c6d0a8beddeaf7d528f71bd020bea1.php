<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>在线客服端</title>
    <link id="zuithumb" href="/Public/dist/css/zui.css" rel="stylesheet">
    <link href="/Public/dist/css/common.css" rel="stylesheet">
    <script src="/Public/dist/lib/jquery/jquery.js"></script>
    <script src="/Public/dist/js/zui.min.js"></script>
    <script src="/Public/dist/lib/cookie/jquery.cookie.js"></script>
    <script src="/Public/dist/lib/common/json.js"></script>
    <script src="/Public/dist/js/formvalid.js"></script>
</head>
<body>
<!--[if lt IE 9]>
<div class="alert alert-danger">您正在使用 <strong>过时的</strong> 浏览器. 是时候 <a href="http://browsehappy.com/">更换一个更好的浏览器</a> 来提升用户体验.</div>
<![endif]-->

<nav class="navbar navbar-default header" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="javascript:;"><i class="icon icon-chat-dot"></i> 在线客服</a>
    </div>
    <div class="collapse navbar-collapse navbar-collapse-example">
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-primary">&nbsp;</span> 换肤 <b class="caret"></b></a>
                <ul class="dropdown-menu themelist" role="menu">
                    <li><span class="label theme-black" data-t="black">&nbsp;</span></li>
                    <li><span class="label theme-bluegrey" data-t="bluegrey">&nbsp;</span></li>
                    <li><span class="label theme-indigo" data-t="indigo">&nbsp;</span></li>
                    <li><span class="label theme-yellow" data-t="yellow">&nbsp;</span></li>
                    <li><span class="label theme-brown" data-t="brown">&nbsp;</span></li>
                    <li><span class="label theme-purple" data-t="purple">&nbsp;</span></li>
                    <li><span class="label theme-green" data-t="green">&nbsp;</span></li>
                    <li><span class="label theme-red" data-t="red">&nbsp;</span></li>
                    <li><span class="label theme-blue" data-t="blue">&nbsp;</span></li>
                    <li><span class="label theme-default" data-t="default">&nbsp;</span></li>
                </ul>
            </li>
            <li><a href="http://www.duiler.com" target="_blank"><i class="icon icon-lightbulb"></i> 了解</a></li>
            <?php if($auth == 1): ?><li><a id="switchKf" href="<?php echo U('Manage/Index/index');?>"><i class="icon icon-exchange"></i> 切换为管理模式</a></li><?php endif; ?>
            <li><a><?php echo ($account); ?></a></li>
            <li><a href="<?php echo U('Manage/Login/loginout');?>">退出 <i class="icon icon-signout"></i></a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-xs-2 leftcon">
            <div class="leftpanel">
                <div class="list-group">
                    <a href="<?php echo U('Chat/Index/index');?>" class="list-group-item <?php if((CONTROLLER_NAME) == "Index"): ?>active<?php endif; ?>"><i class="icon-chat"></i> 当前会话</a>
                    <a href="<?php echo U('Chat/History/index');?>" class="list-group-item <?php if((CONTROLLER_NAME) == "History"): ?>active<?php endif; ?>"><i class="icon-history"></i> 历史会话</a>
                    <a href="<?php echo U('Chat/Setting/index');?>" class="list-group-item <?php if((CONTROLLER_NAME) == "Setting"): ?>active<?php endif; ?>"><i class="icon-cog"></i> 设置</a>
                    <a href="http://chat.duiler.com/index.php/Client/Index/index/sysid/97b6e749ee9553c1b93cb8fdfdf47485.html" target="_blank" class="list-group-item"><i class="icon-comments-alt"></i> 联系我们</a>
                </div>
            </div>
        </div>
        <div class="col-xs-10 rightcon">
            <div class="rightpanel">
			
                
<div id="chat-main-panel" class="row">
</div>
<script>
    var $b = $("body");
    $(function(){
        //访客信息完善 表单样式修改
        $b.on("mouseenter",".data-panel-input",function(){
            $(this).removeClass("input-b-hide");
        });
        $b.on("mouseleave",".data-panel-input",function(){
            $(this).addClass("input-b-hide");
        });
        //访客信息完善 ajax提交 失去焦点提交
        $b.on("blur",".data-panel-input",function(){
            var $item = $(this);
            var $itemParent = $item.parent();
            if(!visitid || !$item.attr("name"))
                return false;
            var formdata = {
                "visitid":visitid,
                "name":$item.attr("name"),
                "value":$item.val()
            };
            $.ajax({
                type:"post",
                url:"<?php echo U('Chat/Index/setdata');?>",
                data:formdata,
            beforeSend:function(){
                $item.addClass("disabled");
            },
            success:function(data){
                if(data.status==1){
                    $itemParent.addClass("has-success");
                    setTimeout(function(){
                        $itemParent.removeClass("has-success");
                    },1000);
                }else if(data.status==0){
                    $itemParent.addClass("has-error");
                    setTimeout(function(){
                        $itemParent.removeClass("has-error");
                    },1000);
                }
            },
            error:function(){
                $itemParent.addClass("has-error");
                setTimeout(function(){
                    $itemParent.removeClass("has-error");
                },1000);
            },
            complete:function(){
                $item.addClass("disabled");
            }
            });
        });
    });
</script>
<script>
//客服信息变量
var msg = {},
    ws = {},
    uid = <?php echo ($uid); ?>,  //身份uid
    role = "worker",  //客服人员
    relation = "<?php echo ($companyid); ?>", //所属系统标识
    visitid = "";  //当前聊天的访客标识
</script>
<script src="/Public/dist/js/im.js"></script>

            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        //默认主题引入
        var $themename = !!$.cookie("themename")?$.cookie("themename"):"default";
        $("<link>").attr({ rel: "stylesheet",type: "text/css",href: "/Public/dist/css/zui-"+$themename+"-theme.css"}).insertAfter("#zuithumb");
        //主题颜色切换
        $(".themelist").on("click","span",function(){
            $.cookie("themename",$(this).data("t"),{expires:7, path:'/'});
            window.location.reload(true);
        });
        //点击切换客服页面提醒
        $("#switchKf").click(function(e){
            confirm("确定要离开当前页面？") || e.preventDefault();
        });

    });
</script>
</body>
</html>