<?php
// Description: Selects the first compatible global function declaration found in a PHP source file.
declare(strict_types=1);

function fun_4a1f9bd0_select_first_function_i1790960242_v2($var_4a1f9bd0_source_content_str)
{
    if (is_string($var_4a1f9bd0_source_content_str) === FALSE) {
        return array('success' => FALSE, 'definition' => NULL, 'error' => 'The PHP source content must be a string.');
    }
    $var_4a1f9bd0_definitions_arr = fun_c049db77_scan_function_file_i1790960242_v2($var_4a1f9bd0_source_content_str);
    if (count($var_4a1f9bd0_definitions_arr) === 0) {
        return array('success' => FALSE, 'definition' => NULL, 'error' => 'No global named PHP function with a PARAMETERS declaration was found in the source file.');
    }
    $var_4a1f9bd0_definition_arr = $var_4a1f9bd0_definitions_arr[0];
    if (count($var_4a1f9bd0_definition_arr['errors']) > 0) {
        return array('success' => FALSE, 'definition' => NULL, 'error' => implode(' ', $var_4a1f9bd0_definition_arr['errors']));
    }
    return array('success' => TRUE, 'definition' => $var_4a1f9bd0_definition_arr, 'error' => '');
}
