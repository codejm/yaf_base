<?php

/* layouts/header.html */
class __TwigTemplate_4217d30cfb27170b7583c7853b4906daf34a1d86df745b34fecafe6de3a253af extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
\t<head>
\t\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\" />
\t\t<meta charset=\"utf-8\" />
        <title>";
        // line 6
        echo twig_escape_filter($this->env, (isset($context["pageTitle"]) ? $context["pageTitle"] : null), "html", null, true);
        echo " - ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "name", array(), "array"), "html", null, true);
        echo "</title>

\t\t<meta name=\"description\" content=\"overview &amp; stats\" />
\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0\" />

\t\t<!-- bootstrap & fontawesome -->
        <link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/bootstrap.min.css\" />
\t\t<link rel=\"stylesheet\" href=\"//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css\" />

        <!-- page specific plugin styles -->
\t\t<link rel=\"stylesheet\" href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/jquery-ui.custom.min.css\" />
\t\t<link rel=\"stylesheet\" href=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/chosen.css\" />
\t\t<link rel=\"stylesheet\" href=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/datepicker.css\" />
\t\t<link rel=\"stylesheet\" href=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/bootstrap-timepicker.css\" />
\t\t<link rel=\"stylesheet\" href=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/daterangepicker.css\" />
\t\t<link rel=\"stylesheet\" href=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/bootstrap-datetimepicker.css\" />
\t\t<link rel=\"stylesheet\" href=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/colorpicker.css\" />

\t\t<!-- text fonts -->
\t\t<link rel=\"stylesheet\" href=\"//fonts.useso.com/css?family=Open+Sans:400,300\" />

\t\t<!-- ace styles -->
\t\t<link rel=\"stylesheet\" href=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/ace.min.css\" />

\t\t<!--[if lte IE 9]>
\t\t\t<link rel=\"stylesheet\" href=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/ace-part2.min.css\" />
\t\t<![endif]-->
\t\t<link rel=\"stylesheet\" href=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/ace-skins.min.css\" />
\t\t<link rel=\"stylesheet\" href=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/ace-rtl.min.css\" />

\t\t<!--[if lte IE 9]>
\t\t  <link rel=\"stylesheet\" href=\"";
        // line 37
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/ace-ie.min.css\" />
\t\t<![endif]-->

\t\t<!-- inline styles related to this page -->

\t\t<!-- ace settings handler -->
\t\t<script src=\"";
        // line 43
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/ace-extra.min.js\"></script>

\t\t<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

\t\t<!--[if lte IE 8]>
\t\t<script src=\"";
        // line 48
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/html5shiv.js\"></script>
\t\t<script src=\"";
        // line 49
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/respond.min.js\"></script>
\t\t<![endif]-->

\t\t<!-- basic scripts -->

\t\t<!--[if !IE]> -->
\t\t<script src=\"//ajax.useso.com/ajax/libs/jquery/2.1.0/jquery.min.js\"></script>

\t\t<!-- <![endif]-->

\t\t<!--[if IE]>
        <script src=\"//ajax.useso.com/ajax/libs/jquery/1.11.0/jquery.min.js\"></script>
        <![endif]-->

\t\t<!--[if !IE]> -->
\t\t<script type=\"text/javascript\">
\t\t\twindow.jQuery || document.write(\"<script src='";
        // line 65
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery.min.js'>\"+\"<\"+\"/script>\");
\t\t</script>

\t\t<!-- <![endif]-->

\t\t<!--[if IE]>
        <script type=\"text/javascript\">
         window.jQuery || document.write(\"<script src='";
        // line 72
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery1x.min.js'>\"+\"<\"+\"/script>\");
        </script>
        <![endif]-->

\t</head>

\t<body class=\"no-skin\">
\t\t<div id=\"navbar\" class=\"navbar navbar-default\">
\t\t\t<script type=\"text/javascript\">
\t\t\t\ttry{ace.settings.check('navbar' , 'fixed')}catch(e){}
\t\t\t</script>

\t\t\t<div class=\"navbar-container\" id=\"navbar-container\">
\t\t\t\t<button type=\"button\" class=\"navbar-toggle menu-toggler pull-left\" id=\"menu-toggler\">
\t\t\t\t\t<span class=\"sr-only\">Toggle sidebar</span>

\t\t\t\t\t<span class=\"icon-bar\"></span>

\t\t\t\t\t<span class=\"icon-bar\"></span>

\t\t\t\t\t<span class=\"icon-bar\"></span>
\t\t\t\t</button>

\t\t\t\t<div class=\"navbar-header pull-left\">
\t\t\t\t\t<a href=\"#\" class=\"navbar-brand\">
\t\t\t\t\t\t<small>
\t\t\t\t\t\t\t<i class=\"fa fa-leaf\"></i>
                            ";
        // line 99
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "name", array(), "array"), "html", null, true);
        echo "
\t\t\t\t\t\t</small>
\t\t\t\t\t</a>
\t\t\t\t</div>

\t\t\t\t<div class=\"navbar-buttons navbar-header pull-right\" role=\"navigation\">
\t\t\t\t\t<ul class=\"nav ace-nav\">
\t\t\t\t\t\t<li class=\"light-blue\">
\t\t\t\t\t\t\t<a data-toggle=\"dropdown\" href=\"#\" class=\"dropdown-toggle\">
\t\t\t\t\t\t\t\t<img class=\"nav-user-photo\" src=\"";
        // line 108
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/avatars/user.jpg\" alt=\"Jason's Photo\" />
\t\t\t\t\t\t\t\t<span class=\"user-info\">
\t\t\t\t\t\t\t\t\t<small>Welcome,</small>
                                    ";
        // line 111
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["member"]) ? $context["member"] : null), "username", array(), "array"), "html", null, true);
        echo "
\t\t\t\t\t\t\t\t</span>

\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-caret-down\"></i>
\t\t\t\t\t\t\t</a>

\t\t\t\t\t\t\t<ul class=\"user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close\">
\t\t\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t\t\t<a href=\"#\">
\t\t\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-cog\"></i>
\t\t\t\t\t\t\t\t\t\t设置
\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t</li>

\t\t\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t\t\t<a href=\"profile.html\">
\t\t\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-user\"></i>
\t\t\t\t\t\t\t\t\t\t修改个人资料
\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t</li>

\t\t\t\t\t\t\t\t<li class=\"divider\"></li>

\t\t\t\t\t\t\t\t<li>
                                <a href=\"";
        // line 135
        echo twig_escape_filter($this->env, Tools_help::url("backend/login/logout"), "html", null, true);
        echo "\">
\t\t\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-power-off\"></i>
\t\t\t\t\t\t\t\t\t\t退出
\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</li>
\t\t\t\t\t</ul>
\t\t\t\t</div>
\t\t\t</div><!-- /.navbar-container -->
\t\t</div>

\t\t<div class=\"main-container\" id=\"main-container\">
\t\t\t<script type=\"text/javascript\">
\t\t\t\ttry{ace.settings.check('main-container' , 'fixed')}catch(e){}
\t\t\t</script>

\t\t\t<div id=\"sidebar\" class=\"sidebar                  responsive\">
\t\t\t\t<script type=\"text/javascript\">
\t\t\t\t\ttry{ace.settings.check('sidebar' , 'fixed')}catch(e){}
\t\t\t\t</script>

\t\t\t\t<div class=\"sidebar-shortcuts\" id=\"sidebar-shortcuts\">
\t\t\t\t\t<div class=\"sidebar-shortcuts-large\" id=\"sidebar-shortcuts-large\">
\t\t\t\t\t\t<button class=\"btn btn-success\">
\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-signal\"></i>
\t\t\t\t\t\t</button>

\t\t\t\t\t\t<button class=\"btn btn-info\">
\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-pencil\"></i>
\t\t\t\t\t\t</button>

\t\t\t\t\t\t<button class=\"btn btn-warning\">
\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-users\"></i>
\t\t\t\t\t\t</button>

\t\t\t\t\t\t<button class=\"btn btn-danger\">
\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-cogs\"></i>
\t\t\t\t\t\t</button>
\t\t\t\t\t</div>

\t\t\t\t\t<div class=\"sidebar-shortcuts-mini\" id=\"sidebar-shortcuts-mini\">
\t\t\t\t\t\t<span class=\"btn btn-success\"></span>

\t\t\t\t\t\t<span class=\"btn btn-info\"></span>

\t\t\t\t\t\t<span class=\"btn btn-warning\"></span>

\t\t\t\t\t\t<span class=\"btn btn-danger\"></span>
\t\t\t\t\t</div>
\t\t\t\t</div><!-- /.sidebar-shortcuts -->

                ";
        // line 187
        echo (isset($context["backendMenu"]) ? $context["backendMenu"] : null);
        echo "
\t\t\t\t<!-- /.nav-list -->

\t\t\t\t<div class=\"sidebar-toggle sidebar-collapse\" id=\"sidebar-collapse\">
\t\t\t\t\t<i class=\"ace-icon fa fa-angle-double-left\" data-icon1=\"ace-icon fa fa-angle-double-left\" data-icon2=\"ace-icon fa fa-angle-double-right\"></i>
\t\t\t\t</div>

\t\t\t\t<script type=\"text/javascript\">
\t\t\t\t\ttry{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
\t\t\t\t</script>
\t\t\t</div>

            <div class=\"main-content\">

                <div class=\"breadcrumbs\" id=\"breadcrumbs\">
                    <script type=\"text/javascript\">
            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                    </script>

                    <ul class=\"breadcrumb\">
                        <li>
                        <i class=\"ace-icon fa fa-home home-icon\"></i>
                        <a href=\"#\">主页</a>
                        </li>
                        <li class=\"active\">";
        // line 211
        echo twig_escape_filter($this->env, (isset($context["pageTitle"]) ? $context["pageTitle"] : null), "html", null, true);
        echo "</li>
                    </ul><!-- /.breadcrumb -->
                </div>

                <div class=\"page-content\">

                    <!-- 消息提醒S -->
                    ";
        // line 218
        if ((!twig_test_empty((isset($context["Message"]) ? $context["Message"] : null)))) {
            // line 219
            echo "                    <div class=\"alert alert-success\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\"> <i class=\"ace-icon fa fa-times\"></i> </button>
                        <strong> <i class=\"ace-icon fa fa-check\"></i> ";
            // line 221
            echo twig_escape_filter($this->env, (isset($context["Message"]) ? $context["Message"] : null), "html", null, true);
            echo " </strong> <br>
                    </div>
                    ";
        }
        // line 224
        echo "
                    ";
        // line 225
        if ((!twig_test_empty((isset($context["ErrorMessage"]) ? $context["ErrorMessage"] : null)))) {
            // line 226
            echo "                    <div class=\"alert alert-warning\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\"> <i class=\"ace-icon fa fa-times\"></i> </button>
                        <strong>";
            // line 228
            echo twig_escape_filter($this->env, (isset($context["ErrorMessage"]) ? $context["ErrorMessage"] : null), "html", null, true);
            echo "</strong> <br>
                    </div>
                    ";
        }
        // line 231
        echo "
                    ";
        // line 232
        if ((!twig_test_empty((isset($context["ErrorMessageStop"]) ? $context["ErrorMessageStop"] : null)))) {
            // line 233
            echo "                    <div class=\"alert alert-danger\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\"> <i class=\"ace-icon fa fa-times\"></i> </button>
                        <strong> <i class=\"ace-icon fa fa-times\"></i>";
            // line 235
            echo twig_escape_filter($this->env, (isset($context["ErrorMessageStop"]) ? $context["ErrorMessageStop"] : null), "html", null, true);
            echo "</strong> <br>
                    </div>
                    ";
            // line 237
            echo twig_include($this->env, $context, "layouts/footer.html");
            echo "
                    ";
        }
        // line 239
        echo "                    <!-- 消息提醒E -->

                    <div class=\"ace-settings-container\" id=\"ace-settings-container\">
                        <div class=\"btn btn-app btn-xs btn-warning ace-settings-btn\" id=\"ace-settings-btn\">
                            <i class=\"ace-icon fa fa-cog bigger-150\"></i>
                        </div>

                        <div class=\"ace-settings-box clearfix\" id=\"ace-settings-box\">
                            <div class=\"pull-left width-50\">
                                <div class=\"ace-settings-item\">
                                    <div class=\"pull-left\">
                                        <select id=\"skin-colorpicker\" class=\"hide\">
                                            <option data-skin=\"no-skin\" value=\"#438EB9\">#438EB9</option>
                                            <option data-skin=\"skin-1\" value=\"#222A2D\">#222A2D</option>
                                            <option data-skin=\"skin-2\" value=\"#C6487E\">#C6487E</option>
                                            <option data-skin=\"skin-3\" value=\"#D0D0D0\">#D0D0D0</option>
                                        </select>
                                    </div>
                                    <span>&nbsp; Choose Skin</span>
                                </div>

                                <div class=\"ace-settings-item\">
                                    <input type=\"checkbox\" class=\"ace ace-checkbox-2\" id=\"ace-settings-navbar\" />
                                    <label class=\"lbl\" for=\"ace-settings-navbar\"> Fixed Navbar</label>
                                </div>

                                <div class=\"ace-settings-item\">
                                    <input type=\"checkbox\" class=\"ace ace-checkbox-2\" id=\"ace-settings-sidebar\" />
                                    <label class=\"lbl\" for=\"ace-settings-sidebar\"> Fixed Sidebar</label>
                                </div>

                                <div class=\"ace-settings-item\">
                                    <input type=\"checkbox\" class=\"ace ace-checkbox-2\" id=\"ace-settings-breadcrumbs\" />
                                    <label class=\"lbl\" for=\"ace-settings-breadcrumbs\"> Fixed Breadcrumbs</label>
                                </div>

                                <div class=\"ace-settings-item\">
                                    <input type=\"checkbox\" class=\"ace ace-checkbox-2\" id=\"ace-settings-rtl\" />
                                    <label class=\"lbl\" for=\"ace-settings-rtl\"> Right To Left (rtl)</label>
                                </div>

                                <div class=\"ace-settings-item\">
                                    <input type=\"checkbox\" class=\"ace ace-checkbox-2\" id=\"ace-settings-add-container\" />
                                    <label class=\"lbl\" for=\"ace-settings-add-container\">
                                        Inside
                                        <b>.container</b>
                                    </label>
                                </div>
                            </div><!-- /.pull-left -->

                            <div class=\"pull-left width-50\">
                                <div class=\"ace-settings-item\">
                                    <input type=\"checkbox\" class=\"ace ace-checkbox-2\" id=\"ace-settings-hover\" />
                                    <label class=\"lbl\" for=\"ace-settings-hover\"> Submenu on Hover</label>
                                </div>

                                <div class=\"ace-settings-item\">
                                    <input type=\"checkbox\" class=\"ace ace-checkbox-2\" id=\"ace-settings-compact\" />
                                    <label class=\"lbl\" for=\"ace-settings-compact\"> Compact Sidebar</label>
                                </div>

                                <div class=\"ace-settings-item\">
                                    <input type=\"checkbox\" class=\"ace ace-checkbox-2\" id=\"ace-settings-highlight\" />
                                    <label class=\"lbl\" for=\"ace-settings-highlight\"> Alt. Active Item</label>
                                </div>
                            </div><!-- /.pull-left -->
                        </div><!-- /.ace-settings-box -->
                    </div><!-- /.ace-settings-container -->
";
    }

    public function getTemplateName()
    {
        return "layouts/header.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  361 => 239,  356 => 237,  351 => 235,  347 => 233,  345 => 232,  342 => 231,  336 => 228,  332 => 226,  330 => 225,  327 => 224,  321 => 221,  317 => 219,  315 => 218,  305 => 211,  278 => 187,  223 => 135,  196 => 111,  190 => 108,  178 => 99,  148 => 72,  138 => 65,  119 => 49,  115 => 48,  107 => 43,  98 => 37,  92 => 34,  88 => 33,  83 => 31,  77 => 28,  68 => 22,  64 => 21,  60 => 20,  56 => 19,  52 => 18,  48 => 17,  44 => 16,  37 => 12,  26 => 6,  24 => 3,  19 => 1,);
    }
}
