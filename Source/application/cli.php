<?php
// Description: Non-interactive command-line interface for running the first compatible function in a PHP source file.
declare(strict_types=1); // Enable strict type checking for this application entry point.

$var_1a43d92e_project_root_str = dirname(__DIR__, 2); // Determine the absolute project-folder path once so all internal paths can reuse it.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_e62b0a4d_convert_boolean_i1790960242_v2.php'; // Load application and function boolean conversion support.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_a17d42c1_parse_commandline_i1790960242_v3.php'; // Load RPOS parsing for -, --, +, and ++ options in any order.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_91bd2c54_parse_labeled_file_i1790960242_v2.php'; // Load Content File and Configuration File parsing support.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_2ea317c8_resolve_source_file_i1790960242_v2.php'; // Load target-function file resolution from an application option or configuration.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_b83e90af_parse_parameter_declaration_i1790960242_v2.php'; // Load PARAMETERS declaration parsing support.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_c049db77_scan_function_file_i1790960242_v2.php'; // Load PHP source scanning for compatible global functions.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_4a1f9bd0_select_first_function_i1790960242_v2.php'; // Load first-compatible-function selection support.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_f73c19be_convert_function_argument_i1790960242_v3.php'; // Load declared function-argument conversion support, including array: comma-list conversion.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_3c07a8e1_convert_supplied_arguments_i1790960242_v3.php'; // Load target-function option name, required-state, and value validation support, including declared array conversion.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_56cc5c20_inspect_loaded_function_i1790960242_v2.php'; // Load Reflection-based target-function signature inspection support.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_8a0f9153_validate_value_php_type_i1790960242_v2.php'; // Load final PHP signature value-compatibility validation support.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_7be62fc1_build_positional_arguments_i1790960242_v2.php'; // Load positional argument construction while preserving optional PHP defaults.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_67dd6e31_render_value_i1790960242_v2.php'; // Load plain-text rendering for target-function return values.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_5d9e1742_load_target_function_i1790960242_v2.php'; // Load target PHP source inclusion and contract verification support.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_6bd31470_invoke_target_function_i1790960242_v2.php'; // Load target-function invocation with captured ordinary output.
require_once $var_1a43d92e_project_root_str . '/Source/functions/fun_78ee7f42_emit_errors_i1790960242_v2.php'; // Load centralized conditional error output support.

$var_1a43d92e_parsed_arr = fun_a17d42c1_parse_commandline_i1790960242_v3($argv, TRUE); // Parse application and target-function options independently of their command-line order.
$var_1a43d92e_application_options_arr = $var_1a43d92e_parsed_arr['application_options']; // Store application option values supplied with - or + prefixes.
$var_1a43d92e_application_prefixes_arr = $var_1a43d92e_parsed_arr['application_option_prefixes']; // Store the prefix used for each supplied application option for accurate diagnostics.
$var_1a43d92e_function_options_arr = $var_1a43d92e_parsed_arr['function_options']; // Store loaded-function option values supplied with -- or ++ prefixes.
$var_1a43d92e_function_prefixes_arr = $var_1a43d92e_parsed_arr['function_option_prefixes']; // Store the prefix used for each supplied target-function option for accurate diagnostics.
$var_1a43d92e_errors_arr = $var_1a43d92e_parsed_arr['errors']; // Start the application error collection with command-line parser errors.
$var_1a43d92e_display_output_boo = TRUE; // Enable ordinary output by default as required by RPOS.
$var_1a43d92e_display_errors_boo = TRUE; // Enable error output by default as required by RPOS.

if (array_key_exists('display_errors', $var_1a43d92e_application_options_arr) === TRUE) { // Check whether the user supplied -display_errors or +display_errors with a value.
    $var_1a43d92e_boolean_arr = fun_e62b0a4d_convert_boolean_i1790960242_v2($var_1a43d92e_application_options_arr['display_errors']); // Convert either a raw string or a plus-prefix native boolean into the application setting.
    if ($var_1a43d92e_boolean_arr['success'] === TRUE) { // Check whether the supplied display_errors value is supported.
        $var_1a43d92e_display_errors_boo = $var_1a43d92e_boolean_arr['value']; // Apply the requested error-display setting.
    } else { // Handle an invalid display_errors value.
        $var_1a43d92e_option_prefix_str = $var_1a43d92e_application_prefixes_arr['display_errors'] ?? '-'; // Recover the actual prefix used for this application option.
        $var_1a43d92e_errors_arr[] = $var_1a43d92e_option_prefix_str . 'display_errors: ' . $var_1a43d92e_boolean_arr['error']; // Record the display_errors conversion failure for later output.
    } // End the display_errors conversion-result branch.
} // End the optional display_errors handling block.
if (array_key_exists('display_output', $var_1a43d92e_application_options_arr) === TRUE) { // Check whether the user supplied -display_output or +display_output with a value.
    $var_1a43d92e_boolean_arr = fun_e62b0a4d_convert_boolean_i1790960242_v2($var_1a43d92e_application_options_arr['display_output']); // Convert either a raw string or a plus-prefix native boolean into the application setting.
    if ($var_1a43d92e_boolean_arr['success'] === TRUE) { // Check whether the supplied display_output value is supported.
        $var_1a43d92e_display_output_boo = $var_1a43d92e_boolean_arr['value']; // Apply the requested ordinary-output setting.
    } else { // Handle an invalid display_output value.
        $var_1a43d92e_option_prefix_str = $var_1a43d92e_application_prefixes_arr['display_output'] ?? '-'; // Recover the actual prefix used for this application option.
        $var_1a43d92e_errors_arr[] = $var_1a43d92e_option_prefix_str . 'display_output: ' . $var_1a43d92e_boolean_arr['error']; // Record the display_output conversion failure for later output.
    } // End the display_output conversion-result branch.
} // End the optional display_output handling block.

if ($var_1a43d92e_parsed_arr['help'] === TRUE) { // Check whether the special --help option was requested anywhere on the command line.
    $var_1a43d92e_help_file_str = $var_1a43d92e_project_root_str . '/Source/application/Help.txt'; // Build the help Content File path from the reusable absolute project root.
    $var_1a43d92e_help_arr = fun_91bd2c54_parse_labeled_file_i1790960242_v2($var_1a43d92e_help_file_str); // Parse the formal Content File stored beside the application entry points.
    if ($var_1a43d92e_help_arr['success'] === FALSE) { // Check whether the help Content File could not be parsed.
        fun_78ee7f42_emit_errors_i1790960242_v2($var_1a43d92e_help_arr['errors'], $var_1a43d92e_display_errors_boo); // Emit help-file parsing errors when error display is enabled.
        exit(1); // Stop with failure because help content could not be loaded.
    } // End the help-file parsing failure branch.
    echo $var_1a43d92e_help_arr['entries']['Content']; // Output only the Content value rather than the Content File metadata.
    exit(0); // Stop successfully after displaying help instead of executing a target function.
} // End the --help handling block.

if (PHP_VERSION_ID < 80000) { // Check whether the running PHP interpreter is older than the minimum supported release.
    $var_1a43d92e_errors_arr[] = 'Commandline Interface v0.5 requires PHP 8.0 or newer.'; // Record a clear runtime compatibility error.
} // End the PHP version compatibility check.
if (count($var_1a43d92e_errors_arr) > 0) { // Check whether parsing or application-option conversion produced any errors.
    fun_78ee7f42_emit_errors_i1790960242_v2($var_1a43d92e_errors_arr, $var_1a43d92e_display_errors_boo); // Emit collected application errors according to the active display setting.
    exit(1); // Stop before inspecting or executing a target function.
} // End the early application error check.

$var_1a43d92e_source_result_arr = fun_2ea317c8_resolve_source_file_i1790960242_v2($var_1a43d92e_application_options_arr, $var_1a43d92e_project_root_str); // Resolve the target PHP function file from source_file or Function Path.conf.
if ($var_1a43d92e_source_result_arr['success'] === FALSE) { // Check whether a usable target PHP function file could not be resolved.
    fun_78ee7f42_emit_errors_i1790960242_v2(array($var_1a43d92e_source_result_arr['error']), $var_1a43d92e_display_errors_boo); // Emit the source-resolution error when enabled.
    exit(1); // Stop because there is no function file to inspect or execute.
} // End the source-file resolution failure branch.
$var_1a43d92e_source_file_str = $var_1a43d92e_source_result_arr['path']; // Store the resolved target PHP function file path.
$var_1a43d92e_source_content_uns = file_get_contents($var_1a43d92e_source_file_str); // Read the target PHP source as text before executing it.
if ($var_1a43d92e_source_content_uns === FALSE) { // Check whether the target PHP source file could not be read.
    fun_78ee7f42_emit_errors_i1790960242_v2(array('Could not read the PHP function file: ' . $var_1a43d92e_source_file_str), $var_1a43d92e_display_errors_boo); // Emit the file-read failure when enabled.
    exit(1); // Stop because the target function cannot be discovered safely without its source text.
} // End the target source-file read failure branch.

$var_1a43d92e_selection_arr = fun_4a1f9bd0_select_first_function_i1790960242_v2($var_1a43d92e_source_content_uns); // Find the first compatible global function definition with PARAMETERS metadata.
if ($var_1a43d92e_selection_arr['success'] === FALSE) { // Check whether no compatible target function could be selected.
    fun_78ee7f42_emit_errors_i1790960242_v2(array($var_1a43d92e_selection_arr['error']), $var_1a43d92e_display_errors_boo); // Emit the function-selection failure when enabled.
    exit(1); // Stop because there is no compatible function to invoke.
} // End the function-selection failure branch.
$var_1a43d92e_definition_arr = $var_1a43d92e_selection_arr['definition']; // Store the selected function name and declared parameter metadata.
$var_1a43d92e_conversion_arr = fun_3c07a8e1_convert_supplied_arguments_i1790960242_v3($var_1a43d92e_function_options_arr, $var_1a43d92e_definition_arr['parameters'], $var_1a43d92e_function_prefixes_arr); // Validate function option names, required states, RPOS-converted values, and declared parameter types.
if ($var_1a43d92e_conversion_arr['success'] === FALSE) { // Check whether supplied target-function options failed declaration-level validation.
    fun_78ee7f42_emit_errors_i1790960242_v2($var_1a43d92e_conversion_arr['errors'], $var_1a43d92e_display_errors_boo); // Emit all target-function option validation errors when enabled.
    exit(1); // Stop before loading the target PHP file when its arguments are invalid.
} // End the declared function-option validation failure branch.

$var_1a43d92e_load_arr = fun_5d9e1742_load_target_function_i1790960242_v2($var_1a43d92e_source_file_str, $var_1a43d92e_definition_arr, $var_1a43d92e_display_errors_boo); // Execute the target source file and verify the actual PHP function signature with Reflection.
if ($var_1a43d92e_load_arr['success'] === FALSE) { // Check whether loading or signature inspection failed.
    if ($var_1a43d92e_display_output_boo === TRUE) { // Check whether include-time ordinary output should remain visible.
        echo $var_1a43d92e_load_arr['include_output']; // Reproduce any output emitted before the target file failed validation.
    } // End the include-time output branch.
    fun_78ee7f42_emit_errors_i1790960242_v2($var_1a43d92e_load_arr['errors'], $var_1a43d92e_display_errors_boo); // Emit loading or contract errors when enabled.
    exit(1); // Stop because the target function is not safe to invoke under the discovered contract.
} // End the target-function loading failure branch.

$var_1a43d92e_positional_arr = fun_7be62fc1_build_positional_arguments_i1790960242_v2($var_1a43d92e_conversion_arr['arguments'], $var_1a43d92e_definition_arr['parameters'], $var_1a43d92e_load_arr['contract']); // Build the ordered PHP argument list and fill omitted optional positions from real PHP defaults when necessary.
if ($var_1a43d92e_positional_arr['success'] === FALSE) { // Check whether converted arguments could not be aligned safely to the PHP signature.
    if ($var_1a43d92e_display_output_boo === TRUE) { // Check whether include-time output should be shown before the positional-argument error.
        echo $var_1a43d92e_load_arr['include_output']; // Reproduce any output emitted while loading the target file.
    } // End the include-time output branch.
    fun_78ee7f42_emit_errors_i1790960242_v2($var_1a43d92e_positional_arr['errors'], $var_1a43d92e_display_errors_boo); // Emit positional-argument construction errors when enabled.
    exit(1); // Stop because the target function cannot be called with the supplied/defaulted argument sequence.
} // End the positional-argument construction failure branch.

$var_1a43d92e_invocation_arr = fun_6bd31470_invoke_target_function_i1790960242_v2($var_1a43d92e_definition_arr['name'], $var_1a43d92e_positional_arr['arguments']); // Invoke the selected function while capturing its ordinary output and rendered return value.
if ($var_1a43d92e_invocation_arr['success'] === FALSE) { // Check whether the target function threw an exception or otherwise failed during invocation.
    if ($var_1a43d92e_display_output_boo === TRUE) { // Check whether captured ordinary output should be reproduced.
        echo $var_1a43d92e_load_arr['include_output']; // Output text emitted while loading the target file.
        echo $var_1a43d92e_invocation_arr['output']; // Output text emitted by the target function before it failed.
    } // End the captured ordinary-output branch.
    fun_78ee7f42_emit_errors_i1790960242_v2(array($var_1a43d92e_invocation_arr['error']), $var_1a43d92e_display_errors_boo); // Emit the target-function failure when enabled.
    exit(1); // Stop with failure because invocation did not complete successfully.
} // End the target-function invocation failure branch.

if ($var_1a43d92e_display_output_boo === TRUE) { // Check whether normal output is enabled after a successful invocation.
    echo $var_1a43d92e_load_arr['include_output']; // Output any text emitted while the target PHP file was loaded.
    echo $var_1a43d92e_invocation_arr['output']; // Output any text emitted directly by the target function.
    echo $var_1a43d92e_invocation_arr['rendered_return']; // Output the target function's return value in the application's readable rendering format.
} // End the successful ordinary-output branch.
exit(0); // End the application successfully after the target function completes.
