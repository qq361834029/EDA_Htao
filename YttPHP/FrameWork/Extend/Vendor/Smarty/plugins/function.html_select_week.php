<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * @ignore
 */
require_once(SMARTY_PLUGINS_DIR . 'shared.escape_special_chars.php');
/**
 * @ignore
 */
require_once(SMARTY_PLUGINS_DIR . 'shared.make_timestamp.php');

/**
 * Smarty {html_select_time} function plugin
 *
 * Type:     function<br>
 * Name:     html_select_time<br>
 * Purpose:  Prints the dropdowns for time selection
 *
 * @link http://www.smarty.net/manual/en/language.function.html.select.time.php {html_select_time}
 *          (Smarty online manual)
 * @author Roberto Berto <roberto@berto.net>
 * @author Monte Ohrt <monte AT ohrt DOT com>
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string
 * @uses smarty_make_timestamp()
 */
function smarty_function_html_select_week($params)
{
	$option_separator = "\n";
    $extra_attrs = '';
    foreach ($params as $_key => $_value) {
        switch ($_key) {
            case 'value':
                $$_key = (int)$_value;
                break;
			case 'name':
			case 'empty':
            case 'prefix':
            case 'field_array':
                $$_key = (string)$_value;
                break;
            default:
                if (!is_array($_value)) {
                    $extra_attrs .= ' ' . $_key . '="' . smarty_function_escape_special_chars($_value) . '"';
                } else {
                    trigger_error("html_select_date: extra attribute '$_key' cannot be an array", E_USER_NOTICE);
                }
                break;
        }
    }

	$_html = '<select name="' . $name . '"';
	$_html .= $extra_attrs . '>' . $option_separator;

	if (isset($empty)) {
		$_html .= '<option value="">' . $empty . '</option>' . $option_separator;
	}

	$week	= array(
		0	=> L('sunday'),
		1	=> L('monday'),
		2	=> L('tuesday'),
		3	=> L('wednesday'),
		4	=> L('thursday'),
		5	=> L('friday'),
		6	=> L('saturday'),
	);
	foreach ($week as $_val => $_text) {
		$selected = $value !== null ? $value == $_val : null;
		$_html .= '<option value="' . $_val . '"' . ($selected ? ' selected="selected"' : '') . '>' . $_text . '</option>' . $option_separator;
	}
	$_html .= '</select>';
    return $_html;
}

?>