<?php

class __Mustache_65f3128aab37d6587d4c12e0536be39f extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div class="navbar">';
        $buffer .= "\n";
        $buffer .= $indent . '  <div class="navbar-inner">';
        $buffer .= "\n";
        $buffer .= $indent . '   <div class="container-fluid">';
        $buffer .= "\n";
        $buffer .= $indent . '';
        $buffer .= "\n";
        $buffer .= $indent . '	  <a href="#" class="brand">';
        $buffer .= "\n";
        $buffer .= $indent . '		<small>';
        $buffer .= "\n";
        $buffer .= $indent . '			<i class="';
        $value = $this->resolveValue($context->findDot('site.brand_icon'), $context, $indent);
        $buffer .= htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
        $buffer .= '"></i>';
        $buffer .= "\n";
        $buffer .= $indent . '			';
        $value = $this->resolveValue($context->findDot('site.brand_text'), $context, $indent);
        $buffer .= htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
        $buffer .= '';
        $buffer .= "\n";
        $buffer .= $indent . '		</small>';
        $buffer .= "\n";
        $buffer .= $indent . '	  </a><!--/.brand-->';
        $buffer .= "\n";
        $buffer .= $indent . '';
        $buffer .= "\n";
        $buffer .= $indent . '	  <ul class="nav ace-nav pull-right">';
        $buffer .= "\n";
        if ($partial = $this->mustache->loadPartial('layout.topbar.tasks')) {
            $buffer .= $partial->renderInternal($context, '			');
        }
        if ($partial = $this->mustache->loadPartial('layout.topbar.notifications')) {
            $buffer .= $partial->renderInternal($context, '			');
        }
        if ($partial = $this->mustache->loadPartial('layout.topbar.messages')) {
            $buffer .= $partial->renderInternal($context, '			');
        }
        if ($partial = $this->mustache->loadPartial('layout.topbar.user_menu')) {
            $buffer .= $partial->renderInternal($context, '			');
        }
        $buffer .= $indent . '	  </ul><!--/.ace-nav-->';
        $buffer .= "\n";
        $buffer .= $indent . '';
        $buffer .= "\n";
        $buffer .= $indent . '   </div><!--/.container-fluid-->';
        $buffer .= "\n";
        $buffer .= $indent . '  </div><!--/.navbar-inner-->';
        $buffer .= "\n";
        $buffer .= $indent . '</div>';

        return $buffer;
    }
}
