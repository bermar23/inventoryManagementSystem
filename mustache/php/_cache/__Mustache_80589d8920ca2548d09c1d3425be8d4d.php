<?php

class __Mustache_80589d8920ca2548d09c1d3425be8d4d extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div class="ace-settings-container" id="ace-settings-container">';
        $buffer .= "\n";
        $buffer .= $indent . '	<div class="btn btn-app btn-mini btn-warning ace-settings-btn" id="ace-settings-btn">';
        $buffer .= "\n";
        $buffer .= $indent . '		<i class="icon-cog bigger-150"></i>';
        $buffer .= "\n";
        $buffer .= $indent . '	</div>';
        $buffer .= "\n";
        $buffer .= $indent . '	<div class="ace-settings-box" id="ace-settings-box">';
        $buffer .= "\n";
        $buffer .= $indent . '		<div>';
        $buffer .= "\n";
        $buffer .= $indent . '			<div class="pull-left">';
        $buffer .= "\n";
        $buffer .= $indent . '				<select id="skin-colorpicker" class="hide">';
        $buffer .= "\n";
        $buffer .= $indent . '					<option data-class="default" value="#438EB9">#438EB9</option>';
        $buffer .= "\n";
        $buffer .= $indent . '					<option data-class="skin-1" value="#222A2D">#222A2D</option>';
        $buffer .= "\n";
        $buffer .= $indent . '					<option data-class="skin-2" value="#C6487E">#C6487E</option>';
        $buffer .= "\n";
        $buffer .= $indent . '					<option data-class="skin-3" value="#D0D0D0">#D0D0D0</option>';
        $buffer .= "\n";
        $buffer .= $indent . '				</select>';
        $buffer .= "\n";
        $buffer .= $indent . '			</div>';
        $buffer .= "\n";
        $buffer .= $indent . '			<span>&nbsp; Choose Skin</span>';
        $buffer .= "\n";
        $buffer .= $indent . '		</div>';
        $buffer .= "\n";
        $buffer .= $indent . '		<div><input type="checkbox" class="ace-checkbox-2" id="ace-settings-header" /><label class="lbl" for="ace-settings-header"> Fixed Header</label></div>';
        $buffer .= "\n";
        $buffer .= $indent . '		<div><input type="checkbox" class="ace-checkbox-2" id="ace-settings-sidebar" /><label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label></div>';
        $buffer .= "\n";
        $buffer .= $indent . '		<div><input type="checkbox" class="ace-checkbox-2" id="ace-settings-breadcrumbs" /><label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label></div>';
        $buffer .= "\n";
        $buffer .= $indent . '		<div><input type="checkbox" class="ace-checkbox-2" id="ace-settings-rtl" /><label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label></div>';
        $buffer .= "\n";
        $buffer .= $indent . '	</div>';
        $buffer .= "\n";
        $buffer .= $indent . '</div><!--/#ace-settings-container-->';

        return $buffer;
    }
}
