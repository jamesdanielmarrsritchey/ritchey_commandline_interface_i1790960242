<?php
// Description: Loads the target PHP file under output capture and validates the selected function's actual signature.
declare(strict_types=1);

function fun_5d9e1742_load_target_function_i1790960242_v2($var_5d9e1742_source_file_str, $var_5d9e1742_definition_arr, $var_5d9e1742_display_errors_boo)
{
    if (is_string($var_5d9e1742_source_file_str) === FALSE || is_array($var_5d9e1742_definition_arr) === FALSE || is_bool($var_5d9e1742_display_errors_boo) === FALSE) {
        return array('success' => FALSE, 'contract' => array(), 'include_output' => '', 'errors' => array('The source file must be a string, the function definition must be an array, and display_errors must be a boolean.'));
    }
    ini_set('display_errors', $var_5d9e1742_display_errors_boo === TRUE ? 'stderr' : '0');
    ob_start();
    try {
        require $var_5d9e1742_source_file_str;
    } catch (Throwable $var_5d9e1742_exception_obj) {
        $var_5d9e1742_output_str = (string) ob_get_clean();
        return array('success' => FALSE, 'contract' => array(), 'include_output' => $var_5d9e1742_output_str, 'errors' => array('Loading the PHP function file failed: ' . $var_5d9e1742_exception_obj->getMessage()));
    }
    $var_5d9e1742_output_str = (string) ob_get_clean();

    $var_5d9e1742_contract_arr = fun_56cc5c20_inspect_loaded_function_i1790960242_v2($var_5d9e1742_definition_arr['name'], $var_5d9e1742_definition_arr['parameters']);
    if ($var_5d9e1742_contract_arr['success'] === FALSE) {
        return array('success' => FALSE, 'contract' => $var_5d9e1742_contract_arr, 'include_output' => $var_5d9e1742_output_str, 'errors' => $var_5d9e1742_contract_arr['errors']);
    }

    return array('success' => TRUE, 'contract' => $var_5d9e1742_contract_arr, 'include_output' => $var_5d9e1742_output_str, 'errors' => array());
}
