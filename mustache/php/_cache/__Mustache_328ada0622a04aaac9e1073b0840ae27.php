<?php

class __Mustache_328ada0622a04aaac9e1073b0840ae27 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="breadcrumbs" id="breadcrumbs">';
        $buffer .= "\n";
        $buffer .= $indent . '';
        $buffer .= "\n";
        $buffer .= $indent . '	<ul class="breadcrumb">';
        $buffer .= "\n";
        $buffer .= $indent . '		<li><i class="icon-home home-icon"></i> <a href="#">Home</a><span class="divider"><i class="icon-angle-right arrow-icon"></i></span></li>';
        $buffer .= "\n";
        // 'breadcrumbs.links' section
        $buffer .= $this->section493d6f968f3b0076787b79e95c9169f5($context, $indent, $context->findDot('breadcrumbs.links'));
        $buffer .= $indent . '		<li class="active">';
        $value = $this->resolveValue($context->findDot('breadcrumbs.title'), $context, $indent);
        $buffer .= htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
        $buffer .= '</li>';
        $buffer .= "\n";
        $buffer .= $indent . '	</ul><!--.breadcrumb-->';
        $buffer .= "\n";
        $buffer .= $indent . '';
        $buffer .= "\n";
        $buffer .= $indent . '	<div class="nav-search" id="nav-search">';
        $buffer .= "\n";
        $buffer .= $indent . '		<form class="form-search">';
        $buffer .= "\n";
        $buffer .= $indent . '			<span class="input-icon">';
        $buffer .= "\n";
        $buffer .= $indent . '				<input type="text" placeholder="Search ..." class="input-small nav-search-input" id="nav-search-input" autocomplete="off" />';
        $buffer .= "\n";
        $buffer .= $indent . '				<i class="icon-search nav-search-icon"></i>';
        $buffer .= "\n";
        $buffer .= $indent . '			</span>';
        $buffer .= "\n";
        $buffer .= $indent . '		</form>';
        $buffer .= "\n";
        $buffer .= $indent . '	</div><!--#nav-search-->';
        $buffer .= "\n";
        $buffer .= $indent . '';
        $buffer .= "\n";
        $buffer .= $indent . '</div>';

        return $buffer;
    }

    private function section493d6f968f3b0076787b79e95c9169f5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
		<li><a href="{{link}}">{{title}}</a> <span class="divider"><i class="icon-angle-right arrow-icon"></i></span></li>
		';
            $buffer .= $this->mustache
                ->loadLambda((string) call_user_func($value, $source, $this->lambdaHelper))
                ->renderInternal($context, $indent);
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                $buffer .= $indent . '		<li><a href="';
                $value = $this->resolveValue($context->find('link'), $context, $indent);
                $buffer .= htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
                $buffer .= '">';
                $value = $this->resolveValue($context->find('title'), $context, $indent);
                $buffer .= htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
                $buffer .= '</a> <span class="divider"><i class="icon-angle-right arrow-icon"></i></span></li>';
                $buffer .= "\n";
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
