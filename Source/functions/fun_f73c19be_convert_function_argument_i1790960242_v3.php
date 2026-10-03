<?php
// Description: Converts and validates one option value according to a declared PHP function parameter type, including array list input.
declare(strict_types=1);

function fun_f73c19be_convert_function_argument_i1790960242_v3($var_f73c19be_raw_value_uns, $var_f73c19be_type_uns, $var_f73c19be_allow_unprefixed_array_list_boo = FALSE)
{
    if (is_string($var_f73c19be_type_uns) === FALSE) {
        return array('success' => FALSE, 'value' => NULL, 'error' => 'The declared parameter type must be a string.');
    } else {
        $var_f73c19be_type_str = $var_f73c19be_type_uns;
    }

    if (is_bool($var_f73c19be_allow_unprefixed_array_list_boo) === FALSE) {
        return array('success' => FALSE, 'value' => NULL, 'error' => 'The unprefixed array-list setting must be a boolean.');
    }

    if ($var_f73c19be_raw_value_uns === NULL) {
        return array('success' => TRUE, 'value' => NULL, 'error' => '');
    }

    if ($var_f73c19be_type_str === 'string') {
        if (is_string($var_f73c19be_raw_value_uns) === TRUE) {
            return array('success' => TRUE, 'value' => $var_f73c19be_raw_value_uns, 'error' => '');
        } else {
            return array('success' => FALSE, 'value' => NULL, 'error' => 'Expected a string value. Use the -- prefix when a literal value must remain a string.');
        }
    } elseif ($var_f73c19be_type_str === 'boolean') {
        return fun_e62b0a4d_convert_boolean_i1790960242_v2($var_f73c19be_raw_value_uns);
    } elseif ($var_f73c19be_type_str === 'number') {
        if (is_int($var_f73c19be_raw_value_uns) === TRUE || is_float($var_f73c19be_raw_value_uns) === TRUE) {
            return array('success' => TRUE, 'value' => $var_f73c19be_raw_value_uns, 'error' => '');
        } elseif (is_string($var_f73c19be_raw_value_uns) === FALSE || is_numeric($var_f73c19be_raw_value_uns) === FALSE) {
            return array('success' => FALSE, 'value' => NULL, 'error' => 'Expected a numeric value.');
        } elseif (preg_match('/^[+-]?\d+$/', $var_f73c19be_raw_value_uns) === 1) {
            return array('success' => TRUE, 'value' => (int) $var_f73c19be_raw_value_uns, 'error' => '');
        } else {
            return array('success' => TRUE, 'value' => (float) $var_f73c19be_raw_value_uns, 'error' => '');
        }
    } elseif ($var_f73c19be_type_str === 'array') {
        if (is_array($var_f73c19be_raw_value_uns) === TRUE) {
            return array('success' => TRUE, 'value' => $var_f73c19be_raw_value_uns, 'error' => '');
        } elseif (is_string($var_f73c19be_raw_value_uns) === FALSE) {
            return array('success' => FALSE, 'value' => NULL, 'error' => 'Expected an array value, a supported comma-separated array list, or JSON that decodes to a PHP array.');
        }

        $var_f73c19be_array_prefix_str = 'array: ';
        $var_f73c19be_has_array_prefix_boo = str_starts_with($var_f73c19be_raw_value_uns, $var_f73c19be_array_prefix_str);
        $var_f73c19be_array_list_str = $var_f73c19be_raw_value_uns;
        if ($var_f73c19be_has_array_prefix_boo === TRUE) {
            $var_f73c19be_array_list_str = substr($var_f73c19be_raw_value_uns, strlen($var_f73c19be_array_prefix_str));
            if (str_contains($var_f73c19be_array_list_str, ',') === FALSE) {
                return array('success' => FALSE, 'value' => NULL, 'error' => 'An array: list must contain a comma-separated list with at least two values.');
            }
            $var_f73c19be_parsed_arr = str_getcsv($var_f73c19be_array_list_str, ',', '"', '\\');
            foreach ($var_f73c19be_parsed_arr as $var_f73c19be_index_num => $var_f73c19be_item_uns) {
                if (is_string($var_f73c19be_item_uns) === TRUE) {
                    $var_f73c19be_parsed_arr[$var_f73c19be_index_num] = trim($var_f73c19be_item_uns);
                }
            }
            return array('success' => TRUE, 'value' => $var_f73c19be_parsed_arr, 'error' => '');
        }

        $var_f73c19be_decoded_uns = json_decode($var_f73c19be_raw_value_uns, TRUE);
        if (json_last_error() === JSON_ERROR_NONE && is_array($var_f73c19be_decoded_uns) === TRUE) {
            return array('success' => TRUE, 'value' => $var_f73c19be_decoded_uns, 'error' => '');
        }

        if ($var_f73c19be_allow_unprefixed_array_list_boo === TRUE && str_contains($var_f73c19be_array_list_str, ',') === TRUE) {
            $var_f73c19be_parsed_arr = str_getcsv($var_f73c19be_array_list_str, ',', '"', '\\');
            foreach ($var_f73c19be_parsed_arr as $var_f73c19be_index_num => $var_f73c19be_item_uns) {
                if (is_string($var_f73c19be_item_uns) === TRUE) {
                    $var_f73c19be_parsed_arr[$var_f73c19be_index_num] = trim($var_f73c19be_item_uns);
                }
            }
            return array('success' => TRUE, 'value' => $var_f73c19be_parsed_arr, 'error' => '');
        }

        if ($var_f73c19be_allow_unprefixed_array_list_boo === TRUE) {
            return array('success' => FALSE, 'value' => NULL, 'error' => 'Expected a comma-separated list with at least two values, an array: comma-separated list, or JSON that decodes to a PHP array.');
        } else {
            return array('success' => FALSE, 'value' => NULL, 'error' => 'Expected an array value beginning with array: followed by a comma-separated list, or JSON that decodes to a PHP array.');
        }
    } elseif ($var_f73c19be_type_str === 'file' || $var_f73c19be_type_str === 'folder') {
        if (is_string($var_f73c19be_raw_value_uns) === FALSE) {
            return array('success' => FALSE, 'value' => NULL, 'error' => 'Expected a path string. Use the -- prefix when a literal path must remain a string.');
        } elseif (trim($var_f73c19be_raw_value_uns) === '') {
            return array('success' => FALSE, 'value' => NULL, 'error' => 'Expected a non-empty path.');
        } else {
            return array('success' => TRUE, 'value' => $var_f73c19be_raw_value_uns, 'error' => '');
        }
    } else {
        return array('success' => FALSE, 'value' => NULL, 'error' => 'Unsupported declared parameter type: ' . $var_f73c19be_type_str);
    }
}
