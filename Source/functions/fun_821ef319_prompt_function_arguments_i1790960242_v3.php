<?php
// Description: Interactively prompts for each declared function parameter and validates each entered value, including comma-separated array input.
declare(strict_types=1);

function fun_821ef319_prompt_function_arguments_i1790960242_v3($var_821ef319_declared_parameters_arr, $var_821ef319_contract_arr, $var_821ef319_display_errors_boo = TRUE)
{
    if (is_array($var_821ef319_declared_parameters_arr) === FALSE || is_array($var_821ef319_contract_arr) === FALSE || is_bool($var_821ef319_display_errors_boo) === FALSE) {
        return array('success' => FALSE, 'arguments' => array(), 'errors' => array('Declared parameters and contract data must be arrays, and display_errors must be a boolean.'));
    }
    $var_821ef319_arguments_arr = array();
    $var_821ef319_errors_arr = array();

    foreach ($var_821ef319_declared_parameters_arr as $var_821ef319_name_str => $var_821ef319_parameter_arr) {
        while (TRUE) {
            $var_821ef319_prompt_str = $var_821ef319_name_str . ' [' . $var_821ef319_parameter_arr['status'] . ', ' . $var_821ef319_parameter_arr['type'] . ']';
            if ($var_821ef319_parameter_arr['type'] === 'array') {
                $var_821ef319_prompt_str .= ' (comma-separated list accepted)';
            }
            if ($var_821ef319_parameter_arr['status'] === 'optional') {
                $var_821ef319_prompt_str .= ' (press Enter to skip)';
            }
            $var_821ef319_prompt_str .= ': ';
            fwrite(STDOUT, $var_821ef319_prompt_str);
            $var_821ef319_input_uns = fgets(STDIN);
            if ($var_821ef319_input_uns === FALSE) {
                $var_821ef319_errors_arr[] = 'Input ended before a value could be read for ' . $var_821ef319_name_str . '.';
                return array('success' => FALSE, 'arguments' => $var_821ef319_arguments_arr, 'errors' => $var_821ef319_errors_arr);
            }
            $var_821ef319_input_str = rtrim($var_821ef319_input_uns, PHP_EOL);

            if ($var_821ef319_input_str === '' && $var_821ef319_parameter_arr['status'] === 'optional') {
                break;
            }
            if ($var_821ef319_input_str === '' && $var_821ef319_parameter_arr['status'] === 'required') {
                if ($var_821ef319_display_errors_boo === TRUE) {
                    fwrite(STDERR, 'A value is required for ' . $var_821ef319_name_str . '.' . PHP_EOL);
                }
                continue;
            }

            $var_821ef319_allow_unprefixed_array_list_boo = $var_821ef319_parameter_arr['type'] === 'array';
            $var_821ef319_conversion_arr = fun_f73c19be_convert_function_argument_i1790960242_v3($var_821ef319_input_str, $var_821ef319_parameter_arr['type'], $var_821ef319_allow_unprefixed_array_list_boo);
            if ($var_821ef319_conversion_arr['success'] === FALSE) {
                if ($var_821ef319_display_errors_boo === TRUE) {
                    fwrite(STDERR, $var_821ef319_conversion_arr['error'] . PHP_EOL);
                }
                continue;
            }

            $var_821ef319_actual_type_str = $var_821ef319_contract_arr['actual_types'][$var_821ef319_name_str] ?? '';
            if (fun_8a0f9153_validate_value_php_type_i1790960242_v2($var_821ef319_conversion_arr['value'], $var_821ef319_actual_type_str) === FALSE) {
                if ($var_821ef319_display_errors_boo === TRUE) {
                    fwrite(STDERR, 'The value does not satisfy the actual PHP parameter type ' . $var_821ef319_actual_type_str . '.' . PHP_EOL);
                }
                continue;
            }

            $var_821ef319_arguments_arr[$var_821ef319_name_str] = $var_821ef319_conversion_arr['value'];
            break;
        }
    }

    return array('success' => TRUE, 'arguments' => $var_821ef319_arguments_arr, 'errors' => array());
}
