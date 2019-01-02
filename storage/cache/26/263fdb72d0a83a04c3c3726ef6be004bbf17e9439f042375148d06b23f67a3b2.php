<?php

/* extension/module/age_restriction.twig */
class __TwigTemplate_aec140cf22d8f322d42a7f2a3aced1ef61b5522d7e5b7b9220e68c2c68504e9f extends Twig_Template
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
        <button type=\"submit\" form=\"form-module\" data-toggle=\"tooltip\" title=\"";
        // line 6
        echo (isset($context["button_save"]) ? $context["button_save"] : null);
        echo "\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i></button>
        <a href=\"";
        // line 7
        echo $this->getAttribute((isset($context["action"]) ? $context["action"] : null), "cancel", array());
        echo "\" data-toggle=\"tooltip\" title=\"";
        echo (isset($context["button_cancel"]) ? $context["button_cancel"] : null);
        echo "\" class=\"btn btn-default\"><i class=\"fa fa-reply\"></i></a></div>
      <h1>";
        // line 8
        echo (isset($context["heading_title"]) ? $context["heading_title"] : null);
        echo "</h1>
      <ul class=\"breadcrumb\">
        ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["breadcrumbs"]) ? $context["breadcrumbs"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 11
            echo "        <li><a href=\"";
            echo $this->getAttribute($context["breadcrumb"], "href", array());
            echo "\">";
            echo $this->getAttribute($context["breadcrumb"], "text", array());
            echo "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "      </ul>
    </div>
  </div>
  <div class=\"container-fluid\">
    ";
        // line 17
        if ($this->getAttribute((isset($context["error"]) ? $context["error"] : null), "permission", array())) {
            // line 18
            echo "    <div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo (isset($context["error_permission"]) ? $context["error_permission"] : null);
            echo "
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    </div>
    ";
        } elseif ((twig_length_filter($this->env,         // line 21
(isset($context["error"]) ? $context["error"] : null)) > 0)) {
            // line 22
            echo "    <div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo (isset($context["error_warning"]) ? $context["error_warning"] : null);
            echo "
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    </div>
    ";
        }
        // line 26
        echo "    <div class=\"panel panel-default\">
      <div class=\"panel-heading\">
        <h3 class=\"panel-title\"><i class=\"fa fa-pencil\"></i> ";
        // line 28
        echo (isset($context["text_edit"]) ? $context["text_edit"] : null);
        echo "</h3>
      </div>
      <div class=\"panel-body\">
        <form action=\"";
        // line 31
        echo $this->getAttribute((isset($context["action"]) ? $context["action"] : null), "save", array());
        echo "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-module\" class=\"form-horizontal\">
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-message\">";
        // line 33
        echo (isset($context["entry_name"]) ? $context["entry_name"] : null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"name\" value=\"";
        // line 35
        echo (isset($context["name"]) ? $context["name"] : null);
        echo "\" placeholder=\"";
        echo (isset($context["placeholder_name"]) ? $context["placeholder_name"] : null);
        echo "\" id=\"input-message\" class=\"form-control\" />
              ";
        // line 36
        if ($this->getAttribute((isset($context["error"]) ? $context["error"] : null), "name", array())) {
            // line 37
            echo "              <div class=\"text-danger\">";
            echo (isset($context["error_name"]) ? $context["error_name"] : null);
            echo "</div>
              ";
        }
        // line 39
        echo "            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-message\">";
        // line 42
        echo (isset($context["entry_message"]) ? $context["entry_message"] : null);
        echo " <span data-toggle=\"tooltip\" title=\"";
        echo (isset($context["help_message"]) ? $context["help_message"] : null);
        echo "\"></span></label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"message\" value=\"";
        // line 44
        echo (isset($context["message"]) ? $context["message"] : null);
        echo "\" placeholder=\"";
        echo (isset($context["placeholder_message"]) ? $context["placeholder_message"] : null);
        echo "\" id=\"input-message\" class=\"form-control\" />
              ";
        // line 45
        if ($this->getAttribute((isset($context["error"]) ? $context["error"] : null), "message", array())) {
            // line 46
            echo "              <div class=\"text-danger\">";
            echo (isset($context["error_message"]) ? $context["error_message"] : null);
            echo "</div>
              ";
        }
        // line 48
        echo "            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-redirect-url\">";
        // line 51
        echo (isset($context["entry_redirect_url"]) ? $context["entry_redirect_url"] : null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"redirect_url\" value=\"";
        // line 53
        echo (isset($context["redirect_url"]) ? $context["redirect_url"] : null);
        echo "\" placeholder=\"";
        echo (isset($context["placeholder_redirect_url"]) ? $context["placeholder_redirect_url"] : null);
        echo "\" id=\"input-redirect-url\" class=\"form-control\" />
              ";
        // line 54
        if ($this->getAttribute((isset($context["error"]) ? $context["error"] : null), "redirect_url", array())) {
            // line 55
            echo "              <div class=\"text-danger\">";
            echo (isset($context["error_redirect_url"]) ? $context["error_redirect_url"] : null);
            echo "</div>
              ";
        }
        // line 57
        echo "            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-age\">";
        // line 60
        echo (isset($context["entry_age"]) ? $context["entry_age"] : null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"age\" value=\"";
        // line 62
        echo (isset($context["age"]) ? $context["age"] : null);
        echo "\" placeholder=\"";
        echo (isset($context["placeholder_age"]) ? $context["placeholder_age"] : null);
        echo "\" id=\"input-redirect\" class=\"form-control\" />
              ";
        // line 63
        if ($this->getAttribute((isset($context["error"]) ? $context["error"] : null), "age", array())) {
            // line 64
            echo "              <div class=\"text-danger\">";
            echo (isset($context["error_age"]) ? $context["error_age"] : null);
            echo "</div>
              ";
        }
        // line 66
        echo "            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-status\">";
        // line 69
        echo (isset($context["entry_status"]) ? $context["entry_status"] : null);
        echo "</label>
            <div class=\"col-sm-10\">
              <select name=\"status\" id=\"input-status\" class=\"form-control\">
                ";
        // line 72
        if ((isset($context["status"]) ? $context["status"] : null)) {
            // line 73
            echo "                <option value=\"1\" selected=\"selected\">";
            echo (isset($context["text_enabled"]) ? $context["text_enabled"] : null);
            echo "</option>
                <option value=\"0\">";
            // line 74
            echo (isset($context["text_disabled"]) ? $context["text_disabled"] : null);
            echo "</option>
                ";
        } else {
            // line 76
            echo "                <option value=\"1\">";
            echo (isset($context["text_enabled"]) ? $context["text_enabled"] : null);
            echo "</option>
                <option value=\"0\" selected=\"selected\">";
            // line 77
            echo (isset($context["text_disabled"]) ? $context["text_disabled"] : null);
            echo "</option>
                ";
        }
        // line 79
        echo "              </select>
            </div>
          </div>
          <input type=\"hidden\"name=\"module_id\" value=\"";
        // line 82
        echo (isset($context["module_id"]) ? $context["module_id"] : null);
        echo "\" />
        </form>
      </div>
    </div>
  </div>
</div>
";
        // line 88
        echo (isset($context["footer"]) ? $context["footer"] : null);
    }

    public function getTemplateName()
    {
        return "extension/module/age_restriction.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  238 => 88,  229 => 82,  224 => 79,  219 => 77,  214 => 76,  209 => 74,  204 => 73,  202 => 72,  196 => 69,  191 => 66,  185 => 64,  183 => 63,  177 => 62,  172 => 60,  167 => 57,  161 => 55,  159 => 54,  153 => 53,  148 => 51,  143 => 48,  137 => 46,  135 => 45,  129 => 44,  122 => 42,  117 => 39,  111 => 37,  109 => 36,  103 => 35,  98 => 33,  93 => 31,  87 => 28,  83 => 26,  75 => 22,  73 => 21,  66 => 18,  64 => 17,  58 => 13,  47 => 11,  43 => 10,  38 => 8,  32 => 7,  28 => 6,  19 => 1,);
    }
}
/* {{ header }}{{ column_left }}*/
/* <div id="content">*/
/*   <div class="page-header">*/
/*     <div class="container-fluid">*/
/*       <div class="pull-right">*/
/*         <button type="submit" form="form-module" data-toggle="tooltip" title="{{ button_save }}" class="btn btn-primary"><i class="fa fa-save"></i></button>*/
/*         <a href="{{ action.cancel }}" data-toggle="tooltip" title="{{ button_cancel }}" class="btn btn-default"><i class="fa fa-reply"></i></a></div>*/
/*       <h1>{{ heading_title }}</h1>*/
/*       <ul class="breadcrumb">*/
/*         {% for breadcrumb in breadcrumbs %}*/
/*         <li><a href="{{ breadcrumb.href }}">{{ breadcrumb.text }}</a></li>*/
/*         {% endfor %}*/
/*       </ul>*/
/*     </div>*/
/*   </div>*/
/*   <div class="container-fluid">*/
/*     {% if error.permission %}*/
/*     <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> {{ error_permission }}*/
/*       <button type="button" class="close" data-dismiss="alert">&times;</button>*/
/*     </div>*/
/*     {% elseif error|length > 0 %}*/
/*     <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> {{ error_warning }}*/
/*       <button type="button" class="close" data-dismiss="alert">&times;</button>*/
/*     </div>*/
/*     {% endif %}*/
/*     <div class="panel panel-default">*/
/*       <div class="panel-heading">*/
/*         <h3 class="panel-title"><i class="fa fa-pencil"></i> {{ text_edit }}</h3>*/
/*       </div>*/
/*       <div class="panel-body">*/
/*         <form action="{{ action.save }}" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">*/
/*           <div class="form-group">*/
/*             <label class="col-sm-2 control-label" for="input-message">{{ entry_name }}</label>*/
/*             <div class="col-sm-10">*/
/*               <input type="text" name="name" value="{{ name }}" placeholder="{{ placeholder_name }}" id="input-message" class="form-control" />*/
/*               {% if error.name  %}*/
/*               <div class="text-danger">{{ error_name }}</div>*/
/*               {% endif %}*/
/*             </div>*/
/*           </div>*/
/*           <div class="form-group">*/
/*             <label class="col-sm-2 control-label" for="input-message">{{ entry_message }} <span data-toggle="tooltip" title="{{ help_message }}"></span></label>*/
/*             <div class="col-sm-10">*/
/*               <input type="text" name="message" value="{{ message }}" placeholder="{{ placeholder_message }}" id="input-message" class="form-control" />*/
/*               {% if error.message %}*/
/*               <div class="text-danger">{{ error_message }}</div>*/
/*               {% endif %}*/
/*             </div>*/
/*           </div>*/
/*           <div class="form-group">*/
/*             <label class="col-sm-2 control-label" for="input-redirect-url">{{ entry_redirect_url }}</label>*/
/*             <div class="col-sm-10">*/
/*               <input type="text" name="redirect_url" value="{{ redirect_url }}" placeholder="{{ placeholder_redirect_url }}" id="input-redirect-url" class="form-control" />*/
/*               {% if error.redirect_url %}*/
/*               <div class="text-danger">{{ error_redirect_url }}</div>*/
/*               {% endif %}*/
/*             </div>*/
/*           </div>*/
/*           <div class="form-group">*/
/*             <label class="col-sm-2 control-label" for="input-age">{{ entry_age }}</label>*/
/*             <div class="col-sm-10">*/
/*               <input type="text" name="age" value="{{ age }}" placeholder="{{ placeholder_age }}" id="input-redirect" class="form-control" />*/
/*               {% if error.age %}*/
/*               <div class="text-danger">{{ error_age }}</div>*/
/*               {% endif %}*/
/*             </div>*/
/*           </div>*/
/*           <div class="form-group">*/
/*             <label class="col-sm-2 control-label" for="input-status">{{ entry_status }}</label>*/
/*             <div class="col-sm-10">*/
/*               <select name="status" id="input-status" class="form-control">*/
/*                 {% if status %}*/
/*                 <option value="1" selected="selected">{{ text_enabled }}</option>*/
/*                 <option value="0">{{ text_disabled }}</option>*/
/*                 {% else %}*/
/*                 <option value="1">{{ text_enabled }}</option>*/
/*                 <option value="0" selected="selected">{{ text_disabled }}</option>*/
/*                 {% endif %}*/
/*               </select>*/
/*             </div>*/
/*           </div>*/
/*           <input type="hidden"name="module_id" value="{{ module_id }}" />*/
/*         </form>*/
/*       </div>*/
/*     </div>*/
/*   </div>*/
/* </div>*/
/* {{ footer }}*/
