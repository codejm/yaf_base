<?php

/* index/index.html */
class __TwigTemplate_62784e87544163e09579afd5c62bc5dd614f324a37723273c53a91923c49d9a2 extends Twig_Template
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
        echo twig_include($this->env, $context, "layouts/header.html");
        echo "

";
        // line 3
        echo twig_include($this->env, $context, "layouts/footer.html");
        echo "
";
    }

    public function getTemplateName()
    {
        return "index/index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 3,  19 => 1,);
    }
}
