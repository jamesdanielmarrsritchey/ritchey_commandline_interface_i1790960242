<?php
// Description: Reads Ritchey Configuration File Format or Ritchey Content File Format label/value data.
declare(strict_types=1);

function fun_91bd2c54_parse_labeled_file_i1790960242_v2($var_91bd2c54_file_str)
{
    if (is_string($var_91bd2c54_file_str) === FALSE || trim($var_91bd2c54_file_str) === '') {
        return array('success' => FALSE, 'entries' => array(), 'errors' => array('The labeled-file path must be a non-empty string.'));
    }
    if (is_file($var_91bd2c54_file_str) === FALSE || is_readable($var_91bd2c54_file_str) === FALSE) {
        return array('success' => FALSE, 'entries' => array(), 'errors' => array('Could not read file: ' . $var_91bd2c54_file_str));
    }

    $var_91bd2c54_content_uns = file_get_contents($var_91bd2c54_file_str);
    if ($var_91bd2c54_content_uns === FALSE) {
        return array('success' => FALSE, 'entries' => array(), 'errors' => array('Could not read file: ' . $var_91bd2c54_file_str));
    }

    $var_91bd2c54_lines_arr = preg_split('/\R/', $var_91bd2c54_content_uns);
    if ($var_91bd2c54_lines_arr === FALSE) {
        return array('success' => FALSE, 'entries' => array(), 'errors' => array('Could not split file into lines: ' . $var_91bd2c54_file_str));
    }

    $var_91bd2c54_entries_arr = array();
    $var_91bd2c54_errors_arr = array();
    $var_91bd2c54_line_count_num = count($var_91bd2c54_lines_arr);

    for ($var_91bd2c54_index_num = 0; $var_91bd2c54_index_num < $var_91bd2c54_line_count_num; $var_91bd2c54_index_num++) {
        $var_91bd2c54_line_str = (string) $var_91bd2c54_lines_arr[$var_91bd2c54_index_num];
        if (trim($var_91bd2c54_line_str) === '') {
            continue;
        }
        if (preg_match('/^([A-Za-z0-9][A-Za-z0-9 _-]*):(.*)$/', $var_91bd2c54_line_str, $var_91bd2c54_matches_arr) !== 1) {
            $var_91bd2c54_errors_arr[] = 'Invalid labeled entry on line ' . ($var_91bd2c54_index_num + 1) . '.';
            continue;
        }

        $var_91bd2c54_label_str = trim($var_91bd2c54_matches_arr[1]);
        $var_91bd2c54_remainder_str = $var_91bd2c54_matches_arr[2];
        if ($var_91bd2c54_remainder_str !== '') {
            if (str_starts_with($var_91bd2c54_remainder_str, ' ') === FALSE) {
                $var_91bd2c54_errors_arr[] = 'Single-line value for ' . $var_91bd2c54_label_str . ' must begin with one space.';
                continue;
            }
            $var_91bd2c54_entries_arr[$var_91bd2c54_label_str] = substr($var_91bd2c54_remainder_str, 1);
            continue;
        }

        $var_91bd2c54_marker_index_num = $var_91bd2c54_index_num + 1;
        if ($var_91bd2c54_marker_index_num >= $var_91bd2c54_line_count_num) {
            $var_91bd2c54_entries_arr[$var_91bd2c54_label_str] = '';
            continue;
        }
        $var_91bd2c54_marker_str = (string) $var_91bd2c54_lines_arr[$var_91bd2c54_marker_index_num];
        if (preg_match('/^"(?:(?:&[a-z0-9]+)|(?:\([a-z0-9]+\)))?$/', $var_91bd2c54_marker_str) !== 1) {
            $var_91bd2c54_entries_arr[$var_91bd2c54_label_str] = '';
            continue;
        }

        $var_91bd2c54_value_lines_arr = array();
        $var_91bd2c54_found_close_boo = FALSE;
        for ($var_91bd2c54_value_index_num = $var_91bd2c54_marker_index_num + 1; $var_91bd2c54_value_index_num < $var_91bd2c54_line_count_num; $var_91bd2c54_value_index_num++) {
            $var_91bd2c54_value_line_str = (string) $var_91bd2c54_lines_arr[$var_91bd2c54_value_index_num];
            if ($var_91bd2c54_value_line_str === $var_91bd2c54_marker_str) {
                $var_91bd2c54_found_close_boo = TRUE;
                $var_91bd2c54_index_num = $var_91bd2c54_value_index_num;
                break;
            }
            $var_91bd2c54_value_lines_arr[] = $var_91bd2c54_value_line_str;
        }
        if ($var_91bd2c54_found_close_boo === FALSE) {
            $var_91bd2c54_errors_arr[] = 'Multi-line value for ' . $var_91bd2c54_label_str . ' does not have a matching closing marker.';
            break;
        }
        $var_91bd2c54_entries_arr[$var_91bd2c54_label_str] = implode(PHP_EOL, $var_91bd2c54_value_lines_arr);
    }

    foreach (array('Name', 'Content') as $var_91bd2c54_required_label_str) {
        if (array_key_exists($var_91bd2c54_required_label_str, $var_91bd2c54_entries_arr) === FALSE) {
            $var_91bd2c54_errors_arr[] = 'Required entry is missing: ' . $var_91bd2c54_required_label_str;
        }
    }

    return array('success' => count($var_91bd2c54_errors_arr) === 0, 'entries' => $var_91bd2c54_entries_arr, 'errors' => $var_91bd2c54_errors_arr);
}
