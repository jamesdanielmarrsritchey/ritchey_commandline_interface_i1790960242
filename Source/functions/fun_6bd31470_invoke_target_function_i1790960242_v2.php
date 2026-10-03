<?php
// Description: Invokes the validated target function while capturing ordinary output and rendering its return value.
declare(strict_types=1);

function fun_6bd31470_invoke_target_function_i1790960242_v2($var_6bd31470_function_name_uns, $var_6bd31470_positional_arguments_uns)
{
    if (is_string($var_6bd31470_function_name_uns) === FALSE || $var_6bd31470_function_name_uns === '') {
        return array('success' => FALSE, 'output' => '', 'rendered_return' => '', 'error' => 'The target function name must be a non-empty string.');
    } else {
        $var_6bd31470_function_name_str = $var_6bd31470_function_name_uns;
    }

    if (is_array($var_6bd31470_positional_arguments_uns) === FALSE) {
        return array('success' => FALSE, 'output' => '', 'rendered_return' => '', 'error' => 'The positional argument collection must be an array.');
    } else {
        $var_6bd31470_positional_arguments_arr = $var_6bd31470_positional_arguments_uns;
    }

    if (function_exists($var_6bd31470_function_name_str) === FALSE) {
        return array('success' => FALSE, 'output' => '', 'rendered_return' => '', 'error' => 'The target function is not loaded: ' . $var_6bd31470_function_name_str);
    }

    ob_start();
    try {
        $var_6bd31470_return_value_uns = call_user_func_array($var_6bd31470_function_name_str, $var_6bd31470_positional_arguments_arr);
    } catch (Throwable $var_6bd31470_exception_obj) {
        $var_6bd31470_output_str = (string) ob_get_clean();
        return array('success' => FALSE, 'output' => $var_6bd31470_output_str, 'rendered_return' => '', 'error' => 'The target function failed: ' . $var_6bd31470_exception_obj->getMessage());
    }
    $var_6bd31470_output_str = (string) ob_get_clean();
    return array('success' => TRUE, 'output' => $var_6bd31470_output_str, 'rendered_return' => fun_67dd6e31_render_value_i1790960242_v2($var_6bd31470_return_value_uns), 'error' => '');
}
