<?php
// Description: Parses RPOS application and target-function options without depending on their order.
declare(strict_types=1);

function fun_a17d42c1_parse_commandline_i1790960242_v3($var_a17d42c1_argv_arr, $var_a17d42c1_allow_function_options_boo = TRUE)
{
    if (is_array($var_a17d42c1_argv_arr) === FALSE) {
        return array('application_options' => array(), 'application_option_prefixes' => array(), 'function_options' => array(), 'function_option_prefixes' => array(), 'help' => FALSE, 'errors' => array('The command-line argument collection must be an array.'));
    } else {
        $var_a17d42c1_errors_arr = array();
    }

    if (is_bool($var_a17d42c1_allow_function_options_boo) === FALSE) {
        $var_a17d42c1_errors_arr[] = 'The function-option mode setting must be a boolean.';
        $var_a17d42c1_allow_function_options_boo = TRUE;
    }

    $var_a17d42c1_application_options_arr = array();
    $var_a17d42c1_application_option_prefixes_arr = array();
    $var_a17d42c1_function_options_arr = array();
    $var_a17d42c1_function_option_prefixes_arr = array();
    $var_a17d42c1_help_boo = FALSE;
    $var_a17d42c1_known_application_options_arr = array('source_file', 'display_output', 'display_errors');
    $var_a17d42c1_count_num = count($var_a17d42c1_argv_arr);
    $var_a17d42c1_option_pattern_str = '/^(--|\+\+|-|\+)([a-z][a-z0-9_]*)$/';

    for ($var_a17d42c1_index_num = 1; $var_a17d42c1_index_num < $var_a17d42c1_count_num; $var_a17d42c1_index_num++) {
        $var_a17d42c1_token_str = (string) $var_a17d42c1_argv_arr[$var_a17d42c1_index_num];

        if ($var_a17d42c1_token_str === '--help') {
            $var_a17d42c1_help_boo = TRUE;
            continue;
        }

        if (preg_match($var_a17d42c1_option_pattern_str, $var_a17d42c1_token_str, $var_a17d42c1_matches_arr) !== 1) {
            $var_a17d42c1_errors_arr[] = 'Unexpected command-line token: ' . $var_a17d42c1_token_str;
            continue;
        }

        $var_a17d42c1_prefix_str = $var_a17d42c1_matches_arr[1];
        $var_a17d42c1_option_name_str = $var_a17d42c1_matches_arr[2];
        $var_a17d42c1_application_option_boo = $var_a17d42c1_prefix_str === '-' || $var_a17d42c1_prefix_str === '+';
        $var_a17d42c1_next_index_num = $var_a17d42c1_index_num + 1;
        $var_a17d42c1_has_value_boo = FALSE;
        $var_a17d42c1_next_token_str = '';

        if ($var_a17d42c1_next_index_num < $var_a17d42c1_count_num) {
            $var_a17d42c1_next_token_str = (string) $var_a17d42c1_argv_arr[$var_a17d42c1_next_index_num];
            if ($var_a17d42c1_next_token_str !== '--help' && preg_match($var_a17d42c1_option_pattern_str, $var_a17d42c1_next_token_str) !== 1) {
                $var_a17d42c1_has_value_boo = TRUE;
            }
        }

        if ($var_a17d42c1_application_option_boo === TRUE) {
            if (in_array($var_a17d42c1_option_name_str, $var_a17d42c1_known_application_options_arr, TRUE) === FALSE) {
                $var_a17d42c1_errors_arr[] = 'Unknown Commandline Interface application option: ' . $var_a17d42c1_prefix_str . $var_a17d42c1_option_name_str;
                if ($var_a17d42c1_has_value_boo === TRUE) {
                    $var_a17d42c1_index_num++;
                }
                continue;
            }
        } else {
            if ($var_a17d42c1_allow_function_options_boo === FALSE) {
                $var_a17d42c1_errors_arr[] = 'Interactive mode does not accept target-function options: ' . $var_a17d42c1_prefix_str . $var_a17d42c1_option_name_str;
                if ($var_a17d42c1_has_value_boo === TRUE) {
                    $var_a17d42c1_index_num++;
                }
                continue;
            }
        }

        if ($var_a17d42c1_has_value_boo === FALSE) {
            continue;
        }

        $var_a17d42c1_value_uns = $var_a17d42c1_next_token_str;
        if ($var_a17d42c1_prefix_str === '+' || $var_a17d42c1_prefix_str === '++') {
            if ($var_a17d42c1_next_token_str === 'true' || $var_a17d42c1_next_token_str === 'TRUE' || $var_a17d42c1_next_token_str === 't') {
                $var_a17d42c1_value_uns = TRUE;
            } elseif ($var_a17d42c1_next_token_str === 'false' || $var_a17d42c1_next_token_str === 'FALSE' || $var_a17d42c1_next_token_str === 'f') {
                $var_a17d42c1_value_uns = FALSE;
            } elseif ($var_a17d42c1_next_token_str === 'null' || $var_a17d42c1_next_token_str === 'NULL' || $var_a17d42c1_next_token_str === 'n') {
                $var_a17d42c1_value_uns = NULL;
            } elseif (preg_match('/^[+-]?\d+$/', $var_a17d42c1_next_token_str) === 1) {
                $var_a17d42c1_negative_boo = str_starts_with($var_a17d42c1_next_token_str, '-');
                $var_a17d42c1_digits_str = ltrim($var_a17d42c1_next_token_str, '+-');
                $var_a17d42c1_digits_str = ltrim($var_a17d42c1_digits_str, '0');
                if ($var_a17d42c1_digits_str === '') {
                    $var_a17d42c1_digits_str = '0';
                }
                if ($var_a17d42c1_negative_boo === TRUE) {
                    $var_a17d42c1_limit_str = substr((string) PHP_INT_MIN, 1);
                } else {
                    $var_a17d42c1_limit_str = (string) PHP_INT_MAX;
                }
                $var_a17d42c1_in_range_boo = strlen($var_a17d42c1_digits_str) < strlen($var_a17d42c1_limit_str) || (strlen($var_a17d42c1_digits_str) === strlen($var_a17d42c1_limit_str) && strcmp($var_a17d42c1_digits_str, $var_a17d42c1_limit_str) <= 0);
                if ($var_a17d42c1_in_range_boo === TRUE) {
                    $var_a17d42c1_value_uns = (int) $var_a17d42c1_next_token_str;
                }
            }
        }

        if ($var_a17d42c1_application_option_boo === TRUE) {
            $var_a17d42c1_application_options_arr[$var_a17d42c1_option_name_str] = $var_a17d42c1_value_uns;
            $var_a17d42c1_application_option_prefixes_arr[$var_a17d42c1_option_name_str] = $var_a17d42c1_prefix_str;
        } else {
            $var_a17d42c1_function_options_arr[$var_a17d42c1_option_name_str] = $var_a17d42c1_value_uns;
            $var_a17d42c1_function_option_prefixes_arr[$var_a17d42c1_option_name_str] = $var_a17d42c1_prefix_str;
        }

        $var_a17d42c1_index_num++;
    }

    return array(
        'application_options' => $var_a17d42c1_application_options_arr,
        'application_option_prefixes' => $var_a17d42c1_application_option_prefixes_arr,
        'function_options' => $var_a17d42c1_function_options_arr,
        'function_option_prefixes' => $var_a17d42c1_function_option_prefixes_arr,
        'help' => $var_a17d42c1_help_boo,
        'errors' => $var_a17d42c1_errors_arr,
    );
}
