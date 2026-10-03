<?php
// Description: Validates function option names and converts supplied values using the declared public parameter contract.
declare(strict_types=1);

function fun_3c07a8e1_convert_supplied_arguments_i1790960242_v3($var_3c07a8e1_function_options_uns, $var_3c07a8e1_declared_parameters_uns, $var_3c07a8e1_prefixes_uns = array())
{
    if (is_array($var_3c07a8e1_function_options_uns) === FALSE || is_array($var_3c07a8e1_declared_parameters_uns) === FALSE || is_array($var_3c07a8e1_prefixes_uns) === FALSE) {
        return array('success' => FALSE, 'arguments' => array(), 'errors' => array('Function options, parameter declarations, and option prefixes must be arrays.'));
    } else {
        $var_3c07a8e1_function_options_arr = $var_3c07a8e1_function_options_uns;
        $var_3c07a8e1_declared_parameters_arr = $var_3c07a8e1_declared_parameters_uns;
        $var_3c07a8e1_prefixes_arr = $var_3c07a8e1_prefixes_uns;
    }

    $var_3c07a8e1_errors_arr = array();
    $var_3c07a8e1_converted_arr = array();

    foreach ($var_3c07a8e1_function_options_arr as $var_3c07a8e1_option_name_str => $var_3c07a8e1_raw_value_uns) {
        if (isset($var_3c07a8e1_declared_parameters_arr[$var_3c07a8e1_option_name_str]) === FALSE) {
            $var_3c07a8e1_prefix_str = $var_3c07a8e1_prefixes_arr[$var_3c07a8e1_option_name_str] ?? '--';
            $var_3c07a8e1_errors_arr[] = 'Unknown function parameter option: ' . $var_3c07a8e1_prefix_str . $var_3c07a8e1_option_name_str;
        }
    }

    foreach ($var_3c07a8e1_declared_parameters_arr as $var_3c07a8e1_parameter_name_str => $var_3c07a8e1_parameter_arr) {
        if (($var_3c07a8e1_parameter_arr['status'] ?? '') === 'required' && array_key_exists($var_3c07a8e1_parameter_name_str, $var_3c07a8e1_function_options_arr) === FALSE) {
            $var_3c07a8e1_errors_arr[] = 'Missing required function parameter option: --' . $var_3c07a8e1_parameter_name_str . ' or ++' . $var_3c07a8e1_parameter_name_str;
        }
    }

    foreach ($var_3c07a8e1_function_options_arr as $var_3c07a8e1_option_name_str => $var_3c07a8e1_raw_value_uns) {
        if (isset($var_3c07a8e1_declared_parameters_arr[$var_3c07a8e1_option_name_str]) === FALSE) {
            continue;
        }
        $var_3c07a8e1_declared_type_str = $var_3c07a8e1_declared_parameters_arr[$var_3c07a8e1_option_name_str]['type'];
        $var_3c07a8e1_conversion_arr = fun_f73c19be_convert_function_argument_i1790960242_v3($var_3c07a8e1_raw_value_uns, $var_3c07a8e1_declared_type_str);
        if ($var_3c07a8e1_conversion_arr['success'] === FALSE) {
            $var_3c07a8e1_prefix_str = $var_3c07a8e1_prefixes_arr[$var_3c07a8e1_option_name_str] ?? '--';
            $var_3c07a8e1_errors_arr[] = $var_3c07a8e1_prefix_str . $var_3c07a8e1_option_name_str . ': ' . $var_3c07a8e1_conversion_arr['error'];
            continue;
        }
        $var_3c07a8e1_converted_arr[$var_3c07a8e1_option_name_str] = $var_3c07a8e1_conversion_arr['value'];
    }

    return array('success' => count($var_3c07a8e1_errors_arr) === 0, 'arguments' => $var_3c07a8e1_converted_arr, 'errors' => $var_3c07a8e1_errors_arr);
}
