<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* home.twig */
class __TwigTemplate_d6b583f3f0920156ead063e9e635faf549cac99e94e1bf328341352b1bb0f8e6 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<html>
    <head>
        <meta charset=\"utf-8\"/>
        <title>Slim 3</title>
        <link href='//fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
        <link href='";
        // line 6
        echo twig_escape_filter($this->env, $this->extensions['Slim\Views\TwigExtension']->baseUrl(), "html", null, true);
        echo "/css/style.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <h1>Slim</h1>
        <div>a microframework for PHP</div>
    </body>
</html>
        
";
    }

    public function getTemplateName()
    {
        return "home.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  44 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "home.twig", "C:\\xampp\\htdocs\\_BOOKINGVUEJS\\frontend\\app\\templates\\home.twig");
    }
}
