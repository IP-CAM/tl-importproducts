<?php

/* extension/module/import_xls.twig */
class __TwigTemplate_70013dd425863bbae3685d0d08ab6175914b5db4a6f5e1d14c9d90394f210693 extends Twig_Template
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
        echo (isset($context["column_left"]) ? $context["column_left"] : null);
        echo "
<div id=\"content\">
    <div class=\"page-header\">
        <div class=\"container-fluid\">
            <div class=\"pull-right\">
                ";
        // line 6
        if ((isset($context["button_apply_allowed"]) ? $context["button_apply_allowed"] : null)) {
            // line 7
            echo "                  <button onclick=\"ajax_loading_open();\$('input[name=no_exit]').val(1);save_configuration_ajax(\$('form#";
            echo (isset($context["extension_name"]) ? $context["extension_name"] : null);
            echo "'));\" type=\"submit\" form=\"form-account\" data-toggle=\"tooltip\" title=\"";
            echo (isset($context["apply_changes"]) ? $context["apply_changes"] : null);
            echo "\" class=\"btn btn-primary\"><i class=\"fa fa-check\"></i></button>
                ";
        }
        // line 9
        echo "                
                ";
        // line 10
        if ((isset($context["button_save_allowed"]) ? $context["button_save_allowed"] : null)) {
            // line 11
            echo "                  <button onclick=\"ajax_loading_open();\$('input[name=no_exit]').val(0);\$('form#";
            echo (isset($context["form_view"]) ? $context["form_view"] : null);
            echo "').submit()\" type=\"submit\" form=\"form-account\" data-toggle=\"tooltip\" title=\"";
            echo (isset($context["button_save"]) ? $context["button_save"] : null);
            echo "\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i></button>
                ";
        }
        // line 13
        echo "                
                <a href=\"";
        // line 14
        echo (isset($context["cancel"]) ? $context["cancel"] : null);
        echo "\" data-toggle=\"tooltip\" title=\"";
        echo (isset($context["button_cancel"]) ? $context["button_cancel"] : null);
        echo "\" class=\"btn btn-default\"><i class=\"fa fa-reply\"></i></a>
            </div>
            <h1>";
        // line 16
        echo (isset($context["heading_title"]) ? $context["heading_title"] : null);
        echo "</h1>
            <ul class=\"breadcrumb\">
                ";
        // line 18
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["breadcrumbs"]) ? $context["breadcrumbs"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 19
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
        // line 21
        echo "            </ul>
        </div>
    </div>
    <div class=\"container-fluid\">
        ";
        // line 25
        if ((isset($context["new_version"]) ? $context["new_version"] : null)) {
            // line 26
            echo "            <div class=\"alert alert-info\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo (isset($context["new_version"]) ? $context["new_version"] : null);
            echo "
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
            </div>
        ";
        }
        // line 30
        echo "
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
        echo "
        ";
        // line 37
        if ((isset($context["error_warning_2"]) ? $context["error_warning_2"] : null)) {
            // line 38
            echo "            <div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo (isset($context["error_warning_2"]) ? $context["error_warning_2"] : null);
            echo "
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
            </div>
        ";
        }
        // line 42
        echo "
        ";
        // line 43
        if ((isset($context["info_message"]) ? $context["info_message"] : null)) {
            // line 44
            echo "            <div class=\"alert alert-info\"><i class=\"fa fa-info-circle\"></i> ";
            echo (isset($context["info_message"]) ? $context["info_message"] : null);
            echo "
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
            </div>
        ";
        }
        // line 48
        echo "        
        ";
        // line 49
        if ((isset($context["success_message"]) ? $context["success_message"] : null)) {
            // line 50
            echo "            <div class=\"alert alert-success\"><i class=\"fa fa-check-circle\"></i> ";
            echo (isset($context["success_message"]) ? $context["success_message"] : null);
            echo "
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
            </div>
        ";
        }
        // line 54
        echo "
        <div class=\"panel panel-default\">
            <div class=\"panel-heading\">
                <h3 class=\"panel-title\"><i class=\"fa fa-pencil\"></i> ";
        // line 57
        echo (isset($context["heading_title_2"]) ? $context["heading_title_2"] : null);
        echo "</h3>
            </div>
            <div class=\"panel-body\">
                ";
        // line 60
        if ( !twig_test_empty((isset($context["form"]) ? $context["form"] : null))) {
            // line 61
            echo "                    ";
            echo (isset($context["form"]) ? $context["form"] : null);
            echo "
                ";
        } else {
            // line 63
            echo "                    <script type=\"text/javascript\">
                        \$(function() {
                            \$(document).on(\"keydown\", \"input#license_id\", function (e) {
                                if (e.which == 13) {
                                    ajax_get_form();
                                    event.preventDefault();
                                    return false;
                                }
                            });
                        });
                    </script>
                    <div class=\"license_form_container opencart_";
            // line 74
            echo (isset($context["oc_version"]) ? $context["oc_version"] : null);
            echo "\">
                        <div class=\"row\">
                            <div class=\"col-md-12\">
                                <form id=\"license_form\">
                                    <h2 class=\"heading\">";
            // line 78
            echo (isset($context["text_validate_license"]) ? $context["text_validate_license"] : null);
            echo "</h2>
                                    <input type=\"text\" id=\"license_id\" name=\"license_id\" class=\"form-control\" placeholder=\"";
            // line 79
            echo (isset($context["text_license_id"]) ? $context["text_license_id"] : null);
            echo "\" required=\"\" value=\"";
            echo (isset($context["license_id"]) ? $context["license_id"] : null);
            echo "\">
                                    <a class=\"btn btn-lg btn-primary btn-block\" onclick=\"ajax_get_form();return false;\">";
            // line 80
            echo (isset($context["text_send"]) ? $context["text_send"] : null);
            echo "</a>
                                    ";
            // line 81
            echo (((isset($context["link_trial"]) ? $context["link_trial"] : null)) ? ((isset($context["link_trial"]) ? $context["link_trial"] : null)) : (""));
            echo "
                                </form>
                            </div>
                        </div>
                    </div>
                ";
        }
        // line 87
        echo "            </div>
        </div>
    </div>
</div>

<script type=\"text/javascript\">
    var token = '";
        // line 93
        echo (((isset($context["token"]) ? $context["token"] : null)) ? ((isset($context["token"]) ? $context["token"] : null)) : (""));
        echo "';
    var text_none = '";
        // line 94
        echo (((isset($context["text_none"]) ? $context["text_none"] : null)) ? ((isset($context["text_none"]) ? $context["text_none"] : null)) : (""));
        echo "';
</script>

";
        // line 97
        if ((isset($context["jquery_variables"]) ? $context["jquery_variables"] : null)) {
            // line 98
            echo "    <script type=\"text/javascript\">
        ";
            // line 99
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["jquery_variables"]) ? $context["jquery_variables"] : null));
            foreach ($context['_seq'] as $context["var_name"] => $context["value"]) {
                // line 100
                echo "            ";
                if (preg_match("/^[\\d\\.]+\$/", $context["value"])) {
                    // line 101
                    echo "                var ";
                    echo $context["var_name"];
                    echo " = ";
                    echo $context["value"];
                    echo ";
            ";
                } else {
                    // line 103
                    echo "                var ";
                    echo $context["var_name"];
                    echo " = \"";
                    echo $context["value"];
                    echo "\";
            ";
                }
                // line 105
                echo "        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['var_name'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 106
            echo "    </script>
";
        }
        // line 108
        echo (isset($context["footer"]) ? $context["footer"] : null);
    }

    public function getTemplateName()
    {
        return "extension/module/import_xls.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  267 => 108,  263 => 106,  257 => 105,  249 => 103,  241 => 101,  238 => 100,  234 => 99,  231 => 98,  229 => 97,  223 => 94,  219 => 93,  211 => 87,  202 => 81,  198 => 80,  192 => 79,  188 => 78,  181 => 74,  168 => 63,  162 => 61,  160 => 60,  154 => 57,  149 => 54,  141 => 50,  139 => 49,  136 => 48,  128 => 44,  126 => 43,  123 => 42,  115 => 38,  113 => 37,  110 => 36,  102 => 32,  100 => 31,  97 => 30,  89 => 26,  87 => 25,  81 => 21,  70 => 19,  66 => 18,  61 => 16,  54 => 14,  51 => 13,  43 => 11,  41 => 10,  38 => 9,  30 => 7,  28 => 6,  19 => 1,);
    }
}
/* {{ header }}{{ column_left }}*/
/* <div id="content">*/
/*     <div class="page-header">*/
/*         <div class="container-fluid">*/
/*             <div class="pull-right">*/
/*                 {% if button_apply_allowed %}*/
/*                   <button onclick="ajax_loading_open();$('input[name=no_exit]').val(1);save_configuration_ajax($('form#{{ extension_name }}'));" type="submit" form="form-account" data-toggle="tooltip" title="{{ apply_changes }}" class="btn btn-primary"><i class="fa fa-check"></i></button>*/
/*                 {% endif %}*/
/*                 */
/*                 {% if button_save_allowed %}*/
/*                   <button onclick="ajax_loading_open();$('input[name=no_exit]').val(0);$('form#{{ form_view }}').submit()" type="submit" form="form-account" data-toggle="tooltip" title="{{ button_save }}" class="btn btn-primary"><i class="fa fa-save"></i></button>*/
/*                 {% endif %}*/
/*                 */
/*                 <a href="{{ cancel }}" data-toggle="tooltip" title="{{ button_cancel }}" class="btn btn-default"><i class="fa fa-reply"></i></a>*/
/*             </div>*/
/*             <h1>{{ heading_title }}</h1>*/
/*             <ul class="breadcrumb">*/
/*                 {% for breadcrumb in breadcrumbs %}*/
/*                     <li><a href="{{ breadcrumb.href }}">{{ breadcrumb.text }}</a></li>*/
/*                 {% endfor %}*/
/*             </ul>*/
/*         </div>*/
/*     </div>*/
/*     <div class="container-fluid">*/
/*         {% if new_version %}*/
/*             <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> {{ new_version }}*/
/*                 <button type="button" class="close" data-dismiss="alert">&times;</button>*/
/*             </div>*/
/*         {% endif %}*/
/* */
/*         {% if error_warning_expired %}*/
/*             <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> {{ error_warning_expired }}*/
/*                 <button type="button" class="close" data-dismiss="alert">&times;</button>*/
/*             </div>*/
/*         {% endif %}*/
/* */
/*         {% if error_warning_2 %}*/
/*             <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> {{ error_warning_2 }}*/
/*                 <button type="button" class="close" data-dismiss="alert">&times;</button>*/
/*             </div>*/
/*         {% endif %}*/
/* */
/*         {% if info_message %}*/
/*             <div class="alert alert-info"><i class="fa fa-info-circle"></i> {{ info_message }}*/
/*                 <button type="button" class="close" data-dismiss="alert">&times;</button>*/
/*             </div>*/
/*         {% endif %}*/
/*         */
/*         {% if success_message %}*/
/*             <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ success_message }}*/
/*                 <button type="button" class="close" data-dismiss="alert">&times;</button>*/
/*             </div>*/
/*         {% endif %}*/
/* */
/*         <div class="panel panel-default">*/
/*             <div class="panel-heading">*/
/*                 <h3 class="panel-title"><i class="fa fa-pencil"></i> {{ heading_title_2 }}</h3>*/
/*             </div>*/
/*             <div class="panel-body">*/
/*                 {% if form is not empty %}*/
/*                     {{ form }}*/
/*                 {% else %}*/
/*                     <script type="text/javascript">*/
/*                         $(function() {*/
/*                             $(document).on("keydown", "input#license_id", function (e) {*/
/*                                 if (e.which == 13) {*/
/*                                     ajax_get_form();*/
/*                                     event.preventDefault();*/
/*                                     return false;*/
/*                                 }*/
/*                             });*/
/*                         });*/
/*                     </script>*/
/*                     <div class="license_form_container opencart_{{ oc_version }}">*/
/*                         <div class="row">*/
/*                             <div class="col-md-12">*/
/*                                 <form id="license_form">*/
/*                                     <h2 class="heading">{{ text_validate_license }}</h2>*/
/*                                     <input type="text" id="license_id" name="license_id" class="form-control" placeholder="{{ text_license_id }}" required="" value="{{ license_id }}">*/
/*                                     <a class="btn btn-lg btn-primary btn-block" onclick="ajax_get_form();return false;">{{ text_send }}</a>*/
/*                                     {{ link_trial ? link_trial : '' }}*/
/*                                 </form>*/
/*                             </div>*/
/*                         </div>*/
/*                     </div>*/
/*                 {% endif %}*/
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
/* {{ footer }}*/
