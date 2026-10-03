<?php
// Description: Resolves the target function file from source_file or the project's default configuration file.
declare(strict_types=1);

function fun_2ea317c8_resolve_source_file_i1790960242_v2($var_2ea317c8_application_options_uns, $var_2ea317c8_project_root_uns)
{
    if (is_array($var_2ea317c8_application_options_uns) === FALSE) {
        return array('success' => FALSE, 'path' => '', 'error' => 'Application options must be supplied as an array.');
    } else {
        $var_2ea317c8_application_options_arr = $var_2ea317c8_application_options_uns;
    }

    if (is_string($var_2ea317c8_project_root_uns) === FALSE || trim($var_2ea317c8_project_root_uns) === '') {
        return array('success' => FALSE, 'path' => '', 'error' => 'The project root must be a non-empty string.');
    } else {
        $var_2ea317c8_project_root_str = $var_2ea317c8_project_root_uns;
    }

    if (array_key_exists('source_file', $var_2ea317c8_application_options_arr) === TRUE && $var_2ea317c8_application_options_arr['source_file'] !== NULL && $var_2ea317c8_application_options_arr['source_file'] !== '') {
        if (is_string($var_2ea317c8_application_options_arr['source_file']) === FALSE) {
            return array('success' => FALSE, 'path' => '', 'error' => 'The source_file application option must resolve to a path string. Use -source_file when the literal value must remain a string.');
        } else {
            $var_2ea317c8_source_file_str = $var_2ea317c8_application_options_arr['source_file'];
        }
        if (is_file($var_2ea317c8_source_file_str) === FALSE || is_readable($var_2ea317c8_source_file_str) === FALSE) {
            return array('success' => FALSE, 'path' => '', 'error' => 'The supplied source_file path is not a readable file: ' . $var_2ea317c8_source_file_str);
        } else {
            $var_2ea317c8_real_path_uns = realpath($var_2ea317c8_source_file_str);
            return array('success' => TRUE, 'path' => $var_2ea317c8_real_path_uns === FALSE ? $var_2ea317c8_source_file_str : $var_2ea317c8_real_path_uns, 'error' => '');
        }
    }

    $var_2ea317c8_configuration_file_str = rtrim($var_2ea317c8_project_root_str, '/\\') . '/Source/Configuration Files/Function Path.conf';
    $var_2ea317c8_configuration_arr = fun_91bd2c54_parse_labeled_file_i1790960242_v2($var_2ea317c8_configuration_file_str);
    if ($var_2ea317c8_configuration_arr['success'] === FALSE) {
        return array('success' => FALSE, 'path' => '', 'error' => 'Could not read the default function-path configuration: ' . implode(' ', $var_2ea317c8_configuration_arr['errors']));
    } else {
        $var_2ea317c8_configured_path_str = trim((string) $var_2ea317c8_configuration_arr['entries']['Content']);
    }

    $var_2ea317c8_relative_prefix_str = 'Relative Path: ';
    $var_2ea317c8_absolute_prefix_str = 'Absolute Path: ';

    if (str_starts_with($var_2ea317c8_configured_path_str, $var_2ea317c8_relative_prefix_str) === TRUE) {
        $var_2ea317c8_relative_path_str = substr($var_2ea317c8_configured_path_str, strlen($var_2ea317c8_relative_prefix_str));
        $var_2ea317c8_source_file_str = rtrim($var_2ea317c8_project_root_str, '/\\') . '/' . ltrim($var_2ea317c8_relative_path_str, '/\\');
    } elseif (str_starts_with($var_2ea317c8_configured_path_str, $var_2ea317c8_absolute_prefix_str) === TRUE) {
        $var_2ea317c8_source_file_str = substr($var_2ea317c8_configured_path_str, strlen($var_2ea317c8_absolute_prefix_str));
    } else {
        return array('success' => FALSE, 'path' => '', 'error' => 'The Content value in Function Path.conf must begin with "Relative Path: " or "Absolute Path: ".');
    }

    if (is_file($var_2ea317c8_source_file_str) === FALSE || is_readable($var_2ea317c8_source_file_str) === FALSE) {
        return array('success' => FALSE, 'path' => '', 'error' => 'The configured function path is not a readable file: ' . $var_2ea317c8_source_file_str);
    } else {
        $var_2ea317c8_real_path_uns = realpath($var_2ea317c8_source_file_str);
        return array('success' => TRUE, 'path' => $var_2ea317c8_real_path_uns === FALSE ? $var_2ea317c8_source_file_str : $var_2ea317c8_real_path_uns, 'error' => '');
    }
}
