<?php

/* extension/module/devmanextensions_download_center.twig */
class __TwigTemplate_f60654e9f53168a16fa13c640480362415e4249bf1c4707f7ade5d75cdb50421 extends Twig_Template
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
        echo (isset($context["header"]) ? $context["header"] : null);
        echo "

<script type=\"text/javascript\" src=\"view/javascript/summernote/summernote.js\"></script>
<link href=\"view/javascript/summernote/summernote.css\" rel=\"stylesheet\" />
<script type=\"text/javascript\" src=\"view/javascript/summernote/summernote-image-attributes.js\"></script> 
<script type=\"text/javascript\" src=\"view/javascript/summernote/opencart.js\"></script> 
  
";
        // line 8
        echo (isset($context["column_left"]) ? $context["column_left"] : null);
        echo "
<div id=\"content\">
    <div class=\"page-header\">
        <div class=\"container-fluid\">
            <div class=\"pull-right\">
                ";
        // line 13
        if ((isset($context["button_apply_allowed"]) ? $context["button_apply_allowed"] : null)) {
            // line 14
            echo "                  <button onclick=\"ajax_loading_open();\$('input[name=no_exit]').val(1);save_configuration_ajax(\$('form#";
            echo (isset($context["extension_name"]) ? $context["extension_name"] : null);
            echo "'));\" type=\"submit\" form=\"form-account\" data-toggle=\"tooltip\" title=\"";
            echo (isset($context["apply_changes"]) ? $context["apply_changes"] : null);
            echo "\" class=\"btn btn-primary\"><i class=\"fa fa-check\"></i></button>
                ";
        }
        // line 16
        echo "                
                ";
        // line 17
        if ((isset($context["button_save_allowed"]) ? $context["button_save_allowed"] : null)) {
            // line 18
            echo "                  <button onclick=\"ajax_loading_open();\$('input[name=no_exit]').val(0);\$('form#";
            echo (isset($context["extension_name"]) ? $context["extension_name"] : null);
            echo "').submit()\" type=\"submit\" form=\"form-account\" data-toggle=\"tooltip\" title=\"";
            echo (isset($context["button_save"]) ? $context["button_save"] : null);
            echo "\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i></button>
                ";
        }
        // line 20
        echo "                <a href=\"";
        echo (isset($context["cancel"]) ? $context["cancel"] : null);
        echo "\" data-toggle=\"tooltip\" title=\"";
        echo (isset($context["button_cancel"]) ? $context["button_cancel"] : null);
        echo "\" class=\"btn btn-default\"><i class=\"fa fa-reply\"></i></a>
            </div>
            <h1>";
        // line 22
        echo (isset($context["heading_title_2"]) ? $context["heading_title_2"] : null);
        echo "</h1>
            <ul class=\"breadcrumb\">
                ";
        // line 24
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["breadcrumbs"]) ? $context["breadcrumbs"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 25
            echo "                    <li><a href=\"";
            echo $this->getAttribute($context["breadcrumb"], "href", array());
            echo "\">";
            echo $this->getAttribute($context["breadcrumb"], "text", array());
            echo "</a></li>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "            </ul>
        </div>
    </div>
    <div class=\"container-fluid\">
        ";
        // line 31
        if ((isset($context["error_warning_expired"]) ? $context["error_warning_expired"] : null)) {
            // line 32
            echo "            <div class=\"alert alert-info\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo (isset($context["error_warning_expired"]) ? $context["error_warning_expired"] : null);
            echo "
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
            </div>
        ";
        }
        // line 36
        echo "        ";
        if ((isset($context["error_warning"]) ? $context["error_warning"] : null)) {
            // line 37
            echo "            <div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo (isset($context["error_warning"]) ? $context["error_warning"] : null);
            echo "
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
            </div>
        ";
        }
        // line 41
        echo "
        ";
        // line 42
        if ((isset($context["info_message"]) ? $context["info_message"] : null)) {
            // line 43
            echo "            <div class=\"alert alert-info\"><i class=\"fa fa-info-circle\"></i> ";
            echo (isset($context["info_message"]) ? $context["info_message"] : null);
            echo "
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
            </div>
        ";
        }
        // line 47
        echo "
        ";
        // line 48
        if ((isset($context["success_message"]) ? $context["success_message"] : null)) {
            // line 49
            echo "            <div class=\"alert alert-success\"><i class=\"fa fa-check-circle\"></i> ";
            echo (isset($context["success_message"]) ? $context["success_message"] : null);
            echo "
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
            </div>
        ";
        }
        // line 53
        echo "

        <div class=\"panel panel-default\">
            <div class=\"panel-heading\">
                <h3 class=\"panel-title\">";
        // line 57
        echo (isset($context["heading_title"]) ? $context["heading_title"] : null);
        echo "</h3>
            </div>
            <div class=\"panel-body\">
                <div class=\"download_form_container opencart_";
        // line 60
        echo (isset($context["oc_version"]) ? $context["oc_version"] : null);
        echo "\">
                    <div class=\"row\">
                        <div class=\"col-md-12\">
                            <form id=\"download_form\">
                                <h2 class=\"heading\">";
        // line 64
        echo (isset($context["text_validate_license"]) ? $context["text_validate_license"] : null);
        echo "</h2>
                                <input type=\"text\" id=\"download_id\" name=\"download_id\" class=\"form-control\" placeholder=\"";
        // line 65
        echo (isset($context["text_license_id"]) ? $context["text_license_id"] : null);
        echo "\" required=\"\" value=\"\">
                                <a class=\"btn btn-lg btn-primary btn-block\" onclick=\"ajax_get_downloads(\$('input[name=download_id]').val());return false;\">";
        // line 66
        echo (isset($context["text_send"]) ? $context["text_send"] : null);
        echo "</a>
                                ";
        // line 67
        echo (isset($context["text_download_identifier_recover"]) ? $context["text_download_identifier_recover"] : null);
        echo "
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type=\"text/javascript\">
    var token = '";
        // line 78
        echo (((isset($context["token"]) ? $context["token"] : null)) ? ((isset($context["token"]) ? $context["token"] : null)) : (""));
        echo "';
    var text_none = '";
        // line 79
        echo (((isset($context["text_none"]) ? $context["text_none"] : null)) ? ((isset($context["text_none"]) ? $context["text_none"] : null)) : (""));
        echo "';
</script>

";
        // line 82
        if ((isset($context["jquery_variables"]) ? $context["jquery_variables"] : null)) {
            // line 83
            echo "    <script type=\"text/javascript\">
        ";
            // line 84
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["jquery_variables"]) ? $context["jquery_variables"] : null));
            foreach ($context['_seq'] as $context["var_name"] => $context["value"]) {
                // line 85
                echo "            ";
                if (preg_match("/^[\\d\\.]+\$/", $context["value"])) {
                    // line 86
                    echo "                var ";
                    echo $context["var_name"];
                    echo " = ";
                    echo $context["value"];
                    echo ";
            ";
                } else {
                    // line 88
                    echo "                var ";
                    echo $context["var_name"];
                    echo " = \"";
                    echo $context["value"];
                    echo "\";
            ";
                }
                // line 90
                echo "        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['var_name'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 91
            echo "    </script>
";
        }
        // line 93
        echo "
";
        // line 94
        echo (isset($context["footer"]) ? $context["footer"] : null);
    }

    public function getTemplateName()
    {
        return "extension/module/devmanextensions_download_center.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  237 => 94,  234 => 93,  230 => 91,  224 => 90,  216 => 88,  208 => 86,  205 => 85,  201 => 84,  198 => 83,  196 => 82,  190 => 79,  186 => 78,  172 => 67,  168 => 66,  164 => 65,  160 => 64,  153 => 60,  147 => 57,  141 => 53,  133 => 49,  131 => 48,  128 => 47,  120 => 43,  118 => 42,  115 => 41,  107 => 37,  104 => 36,  96 => 32,  94 => 31,  88 => 27,  77 => 25,  73 => 24,  68 => 22,  60 => 20,  52 => 18,  50 => 17,  47 => 16,  39 => 14,  37 => 13,  29 => 8,  19 => 1,);
    }
}
/* {{ header }}*/
/* */
/* <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>*/
/* <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />*/
/* <script type="text/javascript" src="view/javascript/summernote/summernote-image-attributes.js"></script> */
/* <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script> */
/*   */
/* {{ column_left }}*/
/* <div id="content">*/
/*     <div class="page-header">*/
/*         <div class="container-fluid">*/
/*             <div class="pull-right">*/
/*                 {% if button_apply_allowed %}*/
/*                   <button onclick="ajax_loading_open();$('input[name=no_exit]').val(1);save_configuration_ajax($('form#{{ extension_name }}'));" type="submit" form="form-account" data-toggle="tooltip" title="{{ apply_changes }}" class="btn btn-primary"><i class="fa fa-check"></i></button>*/
/*                 {% endif %}*/
/*                 */
/*                 {% if button_save_allowed %}*/
/*                   <button onclick="ajax_loading_open();$('input[name=no_exit]').val(0);$('form#{{ extension_name }}').submit()" type="submit" form="form-account" data-toggle="tooltip" title="{{ button_save }}" class="btn btn-primary"><i class="fa fa-save"></i></button>*/
/*                 {% endif %}*/
/*                 <a href="{{ cancel }}" data-toggle="tooltip" title="{{ button_cancel }}" class="btn btn-default"><i class="fa fa-reply"></i></a>*/
/*             </div>*/
/*             <h1>{{ heading_title_2 }}</h1>*/
/*             <ul class="breadcrumb">*/
/*                 {% for breadcrumb in breadcrumbs %}*/
/*                     <li><a href="{{ breadcrumb.href }}">{{ breadcrumb.text }}</a></li>*/
/*                 {% endfor %}*/
/*             </ul>*/
/*         </div>*/
/*     </div>*/
/*     <div class="container-fluid">*/
/*         {% if error_warning_expired %}*/
/*             <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> {{ error_warning_expired }}*/
/*                 <button type="button" class="close" data-dismiss="alert">&times;</button>*/
/*             </div>*/
/*         {% endif %}*/
/*         {% if error_warning %}*/
/*             <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> {{ error_warning }}*/
/*                 <button type="button" class="close" data-dismiss="alert">&times;</button>*/
/*             </div>*/
/*         {% endif %}*/
/* */
/*         {% if info_message %}*/
/*             <div class="alert alert-info"><i class="fa fa-info-circle"></i> {{ info_message }}*/
/*                 <button type="button" class="close" data-dismiss="alert">&times;</button>*/
/*             </div>*/
/*         {% endif %}*/
/* */
/*         {% if success_message %}*/
/*             <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ success_message }}*/
/*                 <button type="button" class="close" data-dismiss="alert">&times;</button>*/
/*             </div>*/
/*         {% endif %}*/
/* */
/* */
/*         <div class="panel panel-default">*/
/*             <div class="panel-heading">*/
/*                 <h3 class="panel-title">{{ heading_title }}</h3>*/
/*             </div>*/
/*             <div class="panel-body">*/
/*                 <div class="download_form_container opencart_{{ oc_version }}">*/
/*                     <div class="row">*/
/*                         <div class="col-md-12">*/
/*                             <form id="download_form">*/
/*                                 <h2 class="heading">{{ text_validate_license }}</h2>*/
/*                                 <input type="text" id="download_id" name="download_id" class="form-control" placeholder="{{ text_license_id }}" required="" value="">*/
/*                                 <a class="btn btn-lg btn-primary btn-block" onclick="ajax_get_downloads($('input[name=download_id]').val());return false;">{{ text_send }}</a>*/
/*                                 {{ text_download_identifier_recover }}*/
/*                             </form>*/
/*                         </div>*/
/*                     </div>*/
/*                 </div>*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/* </div>*/
/* */
/* <script type="text/javascript">*/
/*     var token = '{{ token ? token : '' }}';*/
/*     var text_none = '{{ text_none ? text_none : '' }}';*/
/* </script>*/
/* */
/* {% if jquery_variables %}*/
/*     <script type="text/javascript">*/
/*         {% for var_name, value in jquery_variables %}*/
/*             {% if value matches '/^[\\d\\.]+$/' %}*/
/*                 var {{ var_name }} = {{ value }};*/
/*             {% else %}*/
/*                 var {{ var_name }} = "{{ value }}";*/
/*             {% endif %}*/
/*         {% endfor %}*/
/*     </script>*/
/* {% endif %}*/
/* */
/* {{ footer }}*/
