<?php

/* login/index.html */
class __TwigTemplate_541912d61dbd9e66abfa46a27f82548a7f45671b0e16f87b83e98d9dedbc62c7 extends Twig_Template
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

\t\t<meta name=\"description\" content=\"User login page\" />
\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0\" />

\t\t<!-- bootstrap & fontawesome -->
        <link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/bootstrap.min.css\" />
\t\t<link rel=\"stylesheet\" href=\"//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css\" />

\t\t<!-- text fonts -->
\t\t<link rel=\"stylesheet\" href=\"//fonts.useso.com/css?family=Open+Sans:400,300\" />

\t\t<!-- ace styles -->
\t\t<link rel=\"stylesheet\" href=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/ace.min.css\" />

\t\t<!--[if lte IE 9]>
\t\t\t<link rel=\"stylesheet\" href=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/ace-part2.min.css\" />
\t\t<![endif]-->
\t\t<link rel=\"stylesheet\" href=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/ace-rtl.min.css\" />

\t\t<!--[if lte IE 9]>
\t\t  <link rel=\"stylesheet\" href=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/css/ace-ie.min.css\" />
\t\t<![endif]-->

\t\t<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

\t\t<!--[if lt IE 9]>
\t\t<script src=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/html5shiv.js\"></script>
\t\t<script src=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/respond.min.js\"></script>
\t\t<![endif]-->
\t</head>

\t<body class=\"login-layout\">
\t\t<div class=\"main-container\">
\t\t\t<div class=\"main-content\">
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"col-sm-10 col-sm-offset-1\">
\t\t\t\t\t\t<div class=\"login-container\">
\t\t\t\t\t\t\t<div class=\"center\">
\t\t\t\t\t\t\t\t<h1>
\t\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-leaf green\"></i>
\t\t\t\t\t\t\t\t\t<span class=\"red\"> ";
        // line 47
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "name", array(), "array"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t\t\t</h1>
                                <h4 class=\"blue\" id=\"id-company-text\">&copy; ";
        // line 49
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "companyname", array(), "array"), "html", null, true);
        echo "</h4>
\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t<div class=\"space-6\"></div>

\t\t\t\t\t\t\t<div class=\"position-relative\">
\t\t\t\t\t\t\t\t<div id=\"login-box\" class=\"login-box visible widget-box no-border\">
\t\t\t\t\t\t\t\t\t<div class=\"widget-body\">
\t\t\t\t\t\t\t\t\t\t<div class=\"widget-main\">
\t\t\t\t\t\t\t\t\t\t\t<h4 class=\"header blue lighter bigger\">
\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-coffee green\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t请输入您的用户名及密码
\t\t\t\t\t\t\t\t\t\t\t</h4>

\t\t\t\t\t\t\t\t\t\t\t<div class=\"space-6\"></div>
                                            ";
        // line 64
        echo (isset($context["errors"]) ? $context["errors"] : null);
        echo "

                                            <form action=\"";
        // line 66
        echo twig_escape_filter($this->env, Tools_help::url("backend/login/index"), "html", null, true);
        echo "\" method=\"post\">
\t\t\t\t\t\t\t\t\t\t\t\t<fieldset>
\t\t\t\t\t\t\t\t\t\t\t\t\t<label class=\"block clearfix\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"block input-icon input-icon-right\">
                                                            <input type=\"text\" class=\"form-control\" placeholder=\"用户名\" name=\"username\" value=\"";
        // line 70
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["member"]) ? $context["member"] : null), "username"), "html", null, true);
        echo "\" />
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-user\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t\t\t\t</label>

\t\t\t\t\t\t\t\t\t\t\t\t\t<label class=\"block clearfix\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"block input-icon input-icon-right\">
                                                            <input type=\"password\" class=\"form-control\" placeholder=\"密码\" name=\"password\" value=\"";
        // line 77
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["member"]) ? $context["member"] : null), "password"), "html", null, true);
        echo "\"/>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-lock\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t\t\t\t</label>

\t\t\t\t\t\t\t\t\t\t\t\t\t<label class=\"block clearfix\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"block input-icon input-icon-right\">
                                                            <input type=\"text\" class=\"col-xs-6\" placeholder=\"验证码\" name=\"captcha\" value=\"";
        // line 84
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["member"]) ? $context["member"] : null), "captcha"), "html", null, true);
        echo "\"/>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"ace-icon\">
                                                                <img src=\"";
        // line 86
        echo twig_escape_filter($this->env, Tools_help::url("captcha/create"), "html", null, true);
        echo "\" alt=\"\">
                                                            </i>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t\t\t\t</label>

\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"space\"></div>

\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"clearfix\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label class=\"inline\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" class=\"ace\" name=\"rememberme\"/>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"lbl\"> 记住密码</span>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t</label>

\t\t\t\t\t\t\t\t\t\t\t\t\t\t<button type=\"submit\" class=\"width-35 pull-right btn btn-sm btn-primary\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-key\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"bigger-110\">登录</span>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"space-4\"></div>
\t\t\t\t\t\t\t\t\t\t\t\t</fieldset>
\t\t\t\t\t\t\t\t\t\t\t</form>
\t\t\t\t\t\t\t\t\t\t</div><!-- /.widget-main -->

\t\t\t\t\t\t\t\t\t\t<div class=\"toolbar clearfix\">
\t\t\t\t\t\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t\t\t\t\t\t<a href=\"#\" data-target=\"#forgot-box\" class=\"forgot-password-link\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-arrow-left\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t\t忘记密码?
\t\t\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div><!-- /.widget-body -->
\t\t\t\t\t\t\t\t</div><!-- /.login-box -->

\t\t\t\t\t\t\t\t<div id=\"forgot-box\" class=\"forgot-box widget-box no-border\">
\t\t\t\t\t\t\t\t\t<div class=\"widget-body\">
\t\t\t\t\t\t\t\t\t\t<div class=\"widget-main\">
\t\t\t\t\t\t\t\t\t\t\t<h4 class=\"header red lighter bigger\">
\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-key\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t忘记密码，请联系
\t\t\t\t\t\t\t\t\t\t\t</h4>

\t\t\t\t\t\t\t\t\t\t\t<div class=\"space-6\"></div>
\t\t\t\t\t\t\t\t\t\t\t<p>
\t\t\t\t\t\t\t\t\t\t\t\tcodejm#163.com
\t\t\t\t\t\t\t\t\t\t\t</p>
\t\t\t\t\t\t\t\t\t\t</div><!-- /.widget-main -->

\t\t\t\t\t\t\t\t\t\t<div class=\"toolbar center\">
\t\t\t\t\t\t\t\t\t\t\t<a href=\"#\" data-target=\"#login-box\" class=\"back-to-login-link\">
\t\t\t\t\t\t\t\t\t\t\t    返回登录
\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-arrow-right\"></i>
\t\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div><!-- /.widget-body -->
\t\t\t\t\t\t\t\t</div><!-- /.forgot-box -->
\t\t\t\t\t\t\t</div><!-- /.position-relative -->

\t\t\t\t\t\t\t<div class=\"navbar-fixed-top align-right\">
\t\t\t\t\t\t\t\t<br />
\t\t\t\t\t\t\t\t&nbsp;
\t\t\t\t\t\t\t\t<a id=\"btn-login-dark\" href=\"#\">Dark</a>
\t\t\t\t\t\t\t\t&nbsp;
\t\t\t\t\t\t\t\t<span class=\"blue\">/</span>
\t\t\t\t\t\t\t\t&nbsp;
\t\t\t\t\t\t\t\t<a id=\"btn-login-blur\" href=\"#\">Blur</a>
\t\t\t\t\t\t\t\t&nbsp;
\t\t\t\t\t\t\t\t<span class=\"blue\">/</span>
\t\t\t\t\t\t\t\t&nbsp;
\t\t\t\t\t\t\t\t<a id=\"btn-login-light\" href=\"#\">Light</a>
\t\t\t\t\t\t\t\t&nbsp; &nbsp; &nbsp;
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div><!-- /.col -->
\t\t\t\t</div><!-- /.row -->
\t\t\t</div><!-- /.main-content -->
\t\t</div><!-- /.main-container -->

\t\t<!-- basic scripts -->

\t\t<!--[if !IE]> -->
\t\t<script src=\"//ajax.useso.com/ajax/libs/jquery/2.1.0/jquery.min.js\"></script>

\t\t<!-- <![endif]-->

\t\t<!--[if IE]>
<script src=\"//ajax.useso.com/ajax/libs/jquery/1.11.0/jquery.min.js\"></script>
<![endif]-->

\t\t<!--[if !IE]> -->
\t\t<script type=\"text/javascript\">
\t\t\twindow.jQuery || document.write(\"<script src='assets/admin/js/jquery.min.js'>\"+\"<\"+\"/script>\");
\t\t</script>

\t\t<!-- <![endif]-->

\t\t<!--[if IE]>
<script type=\"text/javascript\">
 window.jQuery || document.write(\"<script src='assets/admin/js/jquery1x.min.js'>\"+\"<\"+\"/script>\");
</script>
<![endif]-->
\t\t<script type=\"text/javascript\">
\t\t\tif('ontouchstart' in document.documentElement) document.write(\"<script src='assets/admin/js/jquery.mobile.custom.min.js'>\"+\"<\"+\"/script>\");
\t\t</script>

\t\t<!-- inline scripts related to this page -->
\t\t<script type=\"text/javascript\">
\t\t\tjQuery(function(\$) {
\t\t\t \$(document).on('click', '.toolbar a[data-target]', function(e) {
\t\t\t\te.preventDefault();
\t\t\t\tvar target = \$(this).data('target');
\t\t\t\t\$('.widget-box.visible').removeClass('visible');//hide others
\t\t\t\t\$(target).addClass('visible');//show target
\t\t\t });
\t\t\t});



\t\t\t//you don't need this, just used for changing background
\t\t\tjQuery(function(\$) {
\t\t\t \$('#btn-login-dark').on('click', function(e) {
\t\t\t\t\$('body').attr('class', 'login-layout');
\t\t\t\t\$('#id-text2').attr('class', 'white');
\t\t\t\t\$('#id-company-text').attr('class', 'blue');

\t\t\t\te.preventDefault();
\t\t\t });
\t\t\t \$('#btn-login-light').on('click', function(e) {
\t\t\t\t\$('body').attr('class', 'login-layout light-login');
\t\t\t\t\$('#id-text2').attr('class', 'grey');
\t\t\t\t\$('#id-company-text').attr('class', 'blue');

\t\t\t\te.preventDefault();
\t\t\t });
\t\t\t \$('#btn-login-blur').on('click', function(e) {
\t\t\t\t\$('body').attr('class', 'login-layout blur-login');
\t\t\t\t\$('#id-text2').attr('class', 'white');
\t\t\t\t\$('#id-company-text').attr('class', 'light-blue');

\t\t\t\te.preventDefault();
\t\t\t });

\t\t\t});
\t\t</script>
\t</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "login/index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  153 => 86,  148 => 84,  138 => 77,  128 => 70,  121 => 66,  116 => 64,  98 => 49,  93 => 47,  77 => 34,  73 => 33,  64 => 27,  58 => 24,  53 => 22,  47 => 19,  37 => 12,  26 => 6,  19 => 1,);
    }
}
