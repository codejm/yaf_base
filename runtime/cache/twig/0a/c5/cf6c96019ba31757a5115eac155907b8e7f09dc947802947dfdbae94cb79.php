<?php

/* layouts/footer.html */
class __TwigTemplate_0ac5cf6c96019ba31757a5115eac155907b8e7f09dc947802947dfdbae94cb79 extends Twig_Template
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
        echo "                </div><!-- /.page-content -->
            </div><!-- /.main-content -->
\t\t\t<div class=\"footer\">
\t\t\t\t<div class=\"footer-inner\">
\t\t\t\t\t<div class=\"footer-content\">
\t\t\t\t\t\t<span class=\"bigger-120\">
\t\t\t\t\t\t\t<span class=\"blue bolder\">";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "name", array(), "array"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t\t";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "companyname", array(), "array"), "html", null, true);
        echo " &copy; 2013-2014
\t\t\t\t\t\t</span>

\t\t\t\t\t\t&nbsp; &nbsp;
\t\t\t\t\t\t<span class=\"action-buttons\">
\t\t\t\t\t\t\t<a href=\"#\">
\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-twitter-square light-blue bigger-150\"></i>
\t\t\t\t\t\t\t</a>

\t\t\t\t\t\t\t<a href=\"#\">
\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-facebook-square text-primary bigger-150\"></i>
\t\t\t\t\t\t\t</a>

\t\t\t\t\t\t\t<a href=\"#\">
\t\t\t\t\t\t\t\t<i class=\"ace-icon fa fa-rss-square orange bigger-150\"></i>
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</span>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>

\t\t\t<a href=\"#\" id=\"btn-scroll-up\" class=\"btn-scroll-up btn btn-sm btn-inverse\">
\t\t\t\t<i class=\"ace-icon fa fa-angle-double-up icon-only bigger-110\"></i>
\t\t\t</a>
\t\t</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->
<script src=\"//ajax.useso.com/ajax/libs/jquery/2.1.0/jquery.min.js\"></script>

<!-- <![endif]-->

<!--[if IE]>
        <script src=\"//ajax.useso.com/ajax/libs/jquery/1.11.0/jquery.min.js\"></script>
        <![endif]-->

<!--[if !IE]> -->
<script type=\"text/javascript\">
window.jQuery || document.write(\"<script src='";
        // line 47
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery.min.js'>\"+\"<\"+\"/script>\");
</script>

<!-- <![endif]-->

<!--[if IE]>
        <script type=\"text/javascript\">
         window.jQuery || document.write(\"<script src='";
        // line 54
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery1x.min.js'>\"+\"<\"+\"/script>\");
        </script>
        <![endif]-->

\t\t<script type=\"text/javascript\">
\t\t\tif('ontouchstart' in document.documentElement) document.write(\"<script src='";
        // line 59
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery.mobile.custom.min.js'>\"+\"<\"+\"/script>\");
\t\t</script>
\t\t<script src=\"//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js\"></script>

\t\t<!-- page specific plugin scripts -->

\t\t<!--[if lte IE 8]>
\t\t  <script src=\"";
        // line 66
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/excanvas.min.js\"></script>
\t\t<![endif]-->

        <!-- page specific plugin scripts -->
\t\t<script src=\"";
        // line 70
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery.dataTables.min.js\"></script>
\t\t<script src=\"";
        // line 71
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery.dataTables.bootstrap.js\"></script>
\t\t<!--[if lte IE 8]>
\t\t  <script src=\"";
        // line 73
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/excanvas.min.js\"></script>
\t\t<![endif]-->
\t\t<script src=\"";
        // line 75
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery-ui.custom.min.js\"></script>
\t\t<script src=\"";
        // line 76
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery.ui.touch-punch.min.js\"></script>
\t\t<script src=\"";
        // line 77
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/chosen.jquery.min.js\"></script>
\t\t<script src=\"";
        // line 78
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/fuelux/fuelux.spinner.min.js\"></script>
\t\t<script src=\"";
        // line 79
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/date-time/bootstrap-datepicker.min.js\"></script>
\t\t<script src=\"";
        // line 80
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/date-time/bootstrap-timepicker.min.js\"></script>
\t\t<script src=\"";
        // line 81
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/date-time/moment.min.js\"></script>
\t\t<script src=\"";
        // line 82
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/date-time/daterangepicker.min.js\"></script>
\t\t<script src=\"";
        // line 83
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/date-time/bootstrap-datetimepicker.min.js\"></script>
\t\t<script src=\"";
        // line 84
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/bootstrap-colorpicker.min.js\"></script>
\t\t<script src=\"";
        // line 85
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery.knob.min.js\"></script>
\t\t<script src=\"";
        // line 86
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery.autosize.min.js\"></script>
\t\t<script src=\"";
        // line 87
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery.inputlimiter.1.3.1.min.js\"></script>
\t\t<script src=\"";
        // line 88
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery.maskedinput.min.js\"></script>
\t\t<script src=\"";
        // line 89
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/bootstrap-tag.min.js\"></script>

\t\t<!-- page specific plugin scripts -->
\t\t<script src=\"";
        // line 92
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/markdown/markdown.min.js\"></script>
\t\t<script src=\"";
        // line 93
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/markdown/bootstrap-markdown.min.js\"></script>
\t\t<script src=\"";
        // line 94
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/jquery.hotkeys.min.js\"></script>
\t\t<script src=\"";
        // line 95
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/bootstrap-wysiwyg.js\"></script>
\t\t<script src=\"";
        // line 96
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/bootbox.min.js\"></script>

\t\t<!-- ace scripts -->
\t\t<script src=\"";
        // line 99
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/ace-elements.min.js\"></script>
\t\t<script src=\"";
        // line 100
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "application", array(), "array"), "site", array(), "array"), "assetsUri", array(), "array"), "html", null, true);
        echo "assets/admin/js/ace.min.js\"></script>

        ";
        // line 102
        if (((isset($context["curaction"]) ? $context["curaction"] : null) == "index")) {
            // line 103
            echo "        <script type=\"text/javascript\">
\$(document).ready(function(\$) {
        \$(document).on('click', 'th input:checkbox' , function(){
            var that = this;
            \$(this).closest('table').find('tr > td:first-child input:checkbox')
            .each(function(){
                this.checked = that.checked;
                \$(this).closest('tr').toggleClass('selected');
                });
            });
        \$('.adel').click(function(){
            var r=confirm(\"真的要删除吗？\");
            if(r == true) {
            return true;
            } else {
            return false;
            }
            });

        });
        </script>
        ";
        }
        // line 125
        echo "
        ";
        // line 126
        $this->displayBlock("script", $context, $blocks);
        echo "
        </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "layouts/footer.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  244 => 126,  241 => 125,  217 => 103,  215 => 102,  210 => 100,  206 => 99,  200 => 96,  192 => 94,  188 => 93,  184 => 92,  174 => 88,  170 => 87,  166 => 86,  162 => 85,  158 => 84,  154 => 83,  150 => 82,  146 => 81,  142 => 80,  134 => 78,  130 => 77,  126 => 76,  122 => 75,  117 => 73,  112 => 71,  108 => 70,  101 => 66,  91 => 59,  73 => 47,  31 => 8,  27 => 7,  361 => 239,  356 => 237,  351 => 235,  347 => 233,  345 => 232,  342 => 231,  336 => 228,  332 => 226,  330 => 225,  327 => 224,  321 => 221,  317 => 219,  315 => 218,  305 => 211,  278 => 187,  223 => 135,  196 => 95,  190 => 108,  178 => 89,  148 => 72,  138 => 79,  119 => 49,  115 => 48,  107 => 43,  98 => 37,  92 => 34,  88 => 33,  83 => 54,  77 => 28,  68 => 22,  64 => 21,  60 => 20,  56 => 19,  52 => 18,  48 => 17,  44 => 16,  37 => 12,  26 => 6,  24 => 3,  19 => 1,);
    }
}
