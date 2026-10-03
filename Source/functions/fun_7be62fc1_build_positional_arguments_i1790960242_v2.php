<?php
// Description: Validates converted values against the loaded PHP signature and builds an ordered positional call list.
declare(strict_types=1);

function fun_7be62fc1_build_positional_arguments_i1790960242_v2($var_7be62fc1_converted_arguments_arr, $var_7be62fc1_declared_parameters_arr, $var_7be62fc1_contract_arr)
{
    if (is_array($var_7be62fc1_converted_arguments_arr) === FALSE || is_array($var_7be62fc1_declared_parameters_arr) === FALSE || is_array($var_7be62fc1_contract_arr) === FALSE) {
        return array('success' => FALSE, 'arguments' => array(), 'errors' => array('Converted arguments, declared parameters, and contract data must be arrays.'));
    }
    $var_7be62fc1_errors_arr = array();

    foreach ($var_7be62fc1_converted_arguments_arr as $var_7be62fc1_name_str => $var_7be62fc1_value_uns) {
        $var_7be62fc1_actual_type_str = $var_7be62fc1_contract_arr['actual_types'][$var_7be62fc1_name_str] ?? '';
        if (fun_8a0f9153_validate_value_php_type_i1790960242_v2($var_7be62fc1_value_uns, $var_7be62fc1_actual_type_str) === FALSE) {
            $var_7be62fc1_errors_arr[] = '--' . $var_7be62fc1_name_str . ' does not satisfy the actual PHP parameter type ' . $var_7be62fc1_actual_type_str . '.';
        }
    }

    if (count($var_7be62fc1_errors_arr) > 0) {
        return array('success' => FALSE, 'arguments' => array(), 'errors' => $var_7be62fc1_errors_arr);
    }

    $var_7be62fc1_ordered_parameters_arr = array_values($var_7be62fc1_declared_parameters_arr);
    $var_7be62fc1_last_supplied_index_num = -1;
    foreach ($var_7be62fc1_ordered_parameters_arr as $var_7be62fc1_index_num => $var_7be62fc1_parameter_arr) {
        if (array_key_exists($var_7be62fc1_parameter_arr['name'], $var_7be62fc1_converted_arguments_arr) === TRUE) {
            $var_7be62fc1_last_supplied_index_num = $var_7be62fc1_index_num;
        }
    }

    $var_7be62fc1_positional_arr = array();
    for ($var_7be62fc1_index_num = 0; $var_7be62fc1_index_num <= $var_7be62fc1_last_supplied_index_num; $var_7be62fc1_index_num++) {
        $var_7be62fc1_parameter_arr = $var_7be62fc1_ordered_parameters_arr[$var_7be62fc1_index_num];
        $var_7be62fc1_name_str = $var_7be62fc1_parameter_arr['name'];
        if (array_key_exists($var_7be62fc1_name_str, $var_7be62fc1_converted_arguments_arr) === TRUE) {
            $var_7be62fc1_positional_arr[] = $var_7be62fc1_converted_arguments_arr[$var_7be62fc1_name_str];
            continue;
        }
        $var_7be62fc1_default_arr = $var_7be62fc1_contract_arr['defaults'][$var_7be62fc1_name_str] ?? array('available' => FALSE, 'value' => NULL);
        if ($var_7be62fc1_default_arr['available'] === TRUE) {
            $var_7be62fc1_positional_arr[] = $var_7be62fc1_default_arr['value'];
            continue;
        }
        $var_7be62fc1_errors_arr[] = 'Could not fill omitted parameter --' . $var_7be62fc1_name_str . ' before a later supplied argument because the PHP signature provides no default.';
    }

    return array('success' => count($var_7be62fc1_errors_arr) === 0, 'arguments' => $var_7be62fc1_positional_arr, 'errors' => $var_7be62fc1_errors_arr);
}
