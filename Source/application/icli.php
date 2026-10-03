<?php
// Description: Interactive command-line interface for prompting for arguments to the first compatible function in a PHP source file.
declare(strict_types=1); // Enable strict type checking for this application entry point.

$var_5c2040b1_project_root_str = dirname(__DIR__, 2); // Determine the absolute project-folder path once so all internal paths can reuse it.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_e62b0a4d_convert_boolean_i1790960242_v2.php'; // Load application and prompted-function boolean conversion support.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_a17d42c1_parse_commandline_i1790960242_v3.php'; // Load RPOS parsing for - and + application options while rejecting target-function options in interactive mode.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_91bd2c54_parse_labeled_file_i1790960242_v2.php'; // Load Content File and Configuration File parsing support.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_2ea317c8_resolve_source_file_i1790960242_v2.php'; // Load target-function file resolution from an application option or configuration.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_b83e90af_parse_parameter_declaration_i1790960242_v2.php'; // Load PARAMETERS declaration parsing support.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_c049db77_scan_function_file_i1790960242_v2.php'; // Load PHP source scanning for compatible global functions.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_4a1f9bd0_select_first_function_i1790960242_v2.php'; // Load first-compatible-function selection support.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_f73c19be_convert_function_argument_i1790960242_v3.php'; // Load prompted function-argument conversion support, including comma-separated array input.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_56cc5c20_inspect_loaded_function_i1790960242_v2.php'; // Load Reflection-based target-function signature inspection support.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_8a0f9153_validate_value_php_type_i1790960242_v2.php'; // Load final PHP signature value-compatibility validation support.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_821ef319_prompt_function_arguments_i1790960242_v3.php'; // Load interactive prompting and entered-value validation support, including direct comma-separated array entry.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_7be62fc1_build_positional_arguments_i1790960242_v2.php'; // Load positional argument construction while preserving optional PHP defaults.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_67dd6e31_render_value_i1790960242_v2.php'; // Load plain-text rendering for target-function return values.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_5d9e1742_load_target_function_i1790960242_v2.php'; // Load target PHP source inclusion and contract verification support.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_6bd31470_invoke_target_function_i1790960242_v2.php'; // Load target-function invocation with captured ordinary output.
require_once $var_5c2040b1_project_root_str . '/Source/functions/fun_78ee7f42_emit_errors_i1790960242_v2.php'; // Load centralized conditional error output support.

$var_5c2040b1_parsed_arr = fun_a17d42c1_parse_commandline_i1790960242_v3($argv, FALSE); // Parse only application options and reject -- or ++ target-function options in interactive mode.
$var_5c2040b1_application_options_arr = $var_5c2040b1_parsed_arr['application_options']; // Store application option values supplied with - or + prefixes.
$var_5c2040b1_application_prefixes_arr = $var_5c2040b1_parsed_arr['application_option_prefixes']; // Store the prefix used for each supplied application option for accurate diagnostics.
$var_5c2040b1_errors_arr = $var_5c2040b1_parsed_arr['errors']; // Start the application error collection with command-line parser errors.
$var_5c2040b1_display_output_boo = TRUE; // Enable ordinary output by default as required by RPOS.
$var_5c2040b1_display_errors_boo = TRUE; // Enable error output by default as required by RPOS.

if (array_key_exists('display_errors', $var_5c2040b1_application_options_arr) === TRUE) { // Check whether the user supplied -display_errors or +display_errors with a value.
    $var_5c2040b1_boolean_arr = fun_e62b0a4d_convert_boolean_i1790960242_v2($var_5c2040b1_application_options_arr['display_errors']); // Convert either a raw string or a plus-prefix native boolean into the application setting.
    if ($var_5c2040b1_boolean_arr['success'] === TRUE) { // Check whether the supplied display_errors value is supported.
        $var_5c2040b1_display_errors_boo = $var_5c2040b1_boolean_arr['value']; // Apply the requested error-display setting.
    } else { // Handle an invalid display_errors value.
        $var_5c2040b1_option_prefix_str = $var_5c2040b1_application_prefixes_arr['display_errors'] ?? '-'; // Recover the actual prefix used for this application option.
        $var_5c2040b1_errors_arr[] = $var_5c2040b1_option_prefix_str . 'display_errors: ' . $var_5c2040b1_boolean_arr['error']; // Record the display_errors conversion failure for later output.
    } // End the display_errors conversion-result branch.
} // End the optional display_errors handling block.
if (array_key_exists('display_output', $var_5c2040b1_application_options_arr) === TRUE) { // Check whether the user supplied -display_output or +display_output with a value.
    $var_5c2040b1_boolean_arr = fun_e62b0a4d_convert_boolean_i1790960242_v2($var_5c2040b1_application_options_arr['display_output']); // Convert either a raw string or a plus-prefix native boolean into the application setting.
    if ($var_5c2040b1_boolean_arr['success'] === TRUE) { // Check whether the supplied display_output value is supported.
        $var_5c2040b1_display_output_boo = $var_5c2040b1_boolean_arr['value']; // Apply the requested ordinary-output setting.
    } else { // Handle an invalid display_output value.
        $var_5c2040b1_option_prefix_str = $var_5c2040b1_application_prefixes_arr['display_output'] ?? '-'; // Recover the actual prefix used for this application option.
        $var_5c2040b1_errors_arr[] = $var_5c2040b1_option_prefix_str . 'display_output: ' . $var_5c2040b1_boolean_arr['error']; // Record the display_output conversion failure for later output.
    } // End the display_output conversion-result branch.
} // End the optional display_output handling block.

if ($var_5c2040b1_parsed_arr['help'] === TRUE) { // Check whether the special --help option was requested anywhere on the command line.
    $var_5c2040b1_help_file_str = $var_5c2040b1_project_root_str . '/Source/application/Help.txt'; // Build the help Content File path from the reusable absolute project root.
    $var_5c2040b1_help_arr = fun_91bd2c54_parse_labeled_file_i1790960242_v2($var_5c2040b1_help_file_str); // Parse the formal Content File stored beside the application entry points.
    if ($var_5c2040b1_help_arr['success'] === FALSE) { // Check whether the help Content File could not be parsed.
        fun_78ee7f42_emit_errors_i1790960242_v2($var_5c2040b1_help_arr['errors'], $var_5c2040b1_display_errors_boo); // Emit help-file parsing errors when error display is enabled.
        exit(1); // Stop with failure because help content could not be loaded.
    } // End the help-file parsing failure branch.
    echo $var_5c2040b1_help_arr['entries']['Content']; // Output only the Content value rather than the Content File metadata.
    exit(0); // Stop successfully after displaying help instead of executing a target function.
} // End the --help handling block.

if (PHP_VERSION_ID < 80000) { // Check whether the running PHP interpreter is older than the minimum supported release.
    $var_5c2040b1_errors_arr[] = 'Commandline Interface v0.5 requires PHP 8.0 or newer.'; // Record a clear runtime compatibility error.
} // End the PHP version compatibility check.
if (count($var_5c2040b1_errors_arr) > 0) { // Check whether parsing or application-option conversion produced any errors.
    fun_78ee7f42_emit_errors_i1790960242_v2($var_5c2040b1_errors_arr, $var_5c2040b1_display_errors_boo); // Emit collected application errors according to the active display setting.
    exit(1); // Stop before inspecting or executing a target function.
} // End the early application error check.

$var_5c2040b1_source_result_arr = fun_2ea317c8_resolve_source_file_i1790960242_v2($var_5c2040b1_application_options_arr, $var_5c2040b1_project_root_str); // Resolve the target PHP function file from source_file or Function Path.conf.
if ($var_5c2040b1_source_result_arr['success'] === FALSE) { // Check whether a usable target PHP function file could not be resolved.
    fun_78ee7f42_emit_errors_i1790960242_v2(array($var_5c2040b1_source_result_arr['error']), $var_5c2040b1_display_errors_boo); // Emit the source-resolution error when enabled.
    exit(1); // Stop because there is no function file to inspect or execute.
} // End the source-file resolution failure branch.
$var_5c2040b1_source_file_str = $var_5c2040b1_source_result_arr['path']; // Store the resolved target PHP function file path.
$var_5c2040b1_source_content_uns = file_get_contents($var_5c2040b1_source_file_str); // Read the target PHP source as text before executing it.
if ($var_5c2040b1_source_content_uns === FALSE) { // Check whether the target PHP source file could not be read.
    fun_78ee7f42_emit_errors_i1790960242_v2(array('Could not read the PHP function file: ' . $var_5c2040b1_source_file_str), $var_5c2040b1_display_errors_boo); // Emit the file-read failure when enabled.
    exit(1); // Stop because the target function cannot be discovered safely without its source text.
} // End the target source-file read failure branch.

$var_5c2040b1_selection_arr = fun_4a1f9bd0_select_first_function_i1790960242_v2($var_5c2040b1_source_content_uns); // Find the first compatible global function definition with PARAMETERS metadata.
if ($var_5c2040b1_selection_arr['success'] === FALSE) { // Check whether no compatible target function could be selected.
    fun_78ee7f42_emit_errors_i1790960242_v2(array($var_5c2040b1_selection_arr['error']), $var_5c2040b1_display_errors_boo); // Emit the function-selection failure when enabled.
    exit(1); // Stop because there is no compatible function to invoke.
} // End the function-selection failure branch.
$var_5c2040b1_definition_arr = $var_5c2040b1_selection_arr['definition']; // Store the selected function name and declared parameter metadata.

$var_5c2040b1_load_arr = fun_5d9e1742_load_target_function_i1790960242_v2($var_5c2040b1_source_file_str, $var_5c2040b1_definition_arr, $var_5c2040b1_display_errors_boo); // Execute the target source file and verify the actual PHP function signature with Reflection.
if ($var_5c2040b1_load_arr['success'] === FALSE) { // Check whether loading or signature inspection failed.
    if ($var_5c2040b1_display_output_boo === TRUE) { // Check whether include-time ordinary output should remain visible.
        echo $var_5c2040b1_load_arr['include_output']; // Reproduce any output emitted before the target file failed validation.
    } // End the include-time output branch.
    fun_78ee7f42_emit_errors_i1790960242_v2($var_5c2040b1_load_arr['errors'], $var_5c2040b1_display_errors_boo); // Emit loading or contract errors when enabled.
    exit(1); // Stop because the target function is not safe to invoke under the discovered contract.
} // End the target-function loading failure branch.

$var_5c2040b1_prompt_arr = fun_821ef319_prompt_function_arguments_i1790960242_v3($var_5c2040b1_definition_arr['parameters'], $var_5c2040b1_load_arr['contract'], $var_5c2040b1_display_errors_boo); // Prompt for every declared function parameter and validate each entered value.
if ($var_5c2040b1_prompt_arr['success'] === FALSE) { // Check whether interactive input ended or failed before a complete argument set could be collected.
    fun_78ee7f42_emit_errors_i1790960242_v2($var_5c2040b1_prompt_arr['errors'], $var_5c2040b1_display_errors_boo); // Emit interactive-input errors when enabled.
    exit(1); // Stop because the target function does not have a complete usable argument set.
} // End the interactive prompting failure branch.

$var_5c2040b1_positional_arr = fun_7be62fc1_build_positional_arguments_i1790960242_v2($var_5c2040b1_prompt_arr['arguments'], $var_5c2040b1_definition_arr['parameters'], $var_5c2040b1_load_arr['contract']); // Build the ordered PHP argument list and fill skipped optional positions from real PHP defaults when necessary.
if ($var_5c2040b1_positional_arr['success'] === FALSE) { // Check whether prompted arguments could not be aligned safely to the PHP signature.
    fun_78ee7f42_emit_errors_i1790960242_v2($var_5c2040b1_positional_arr['errors'], $var_5c2040b1_display_errors_boo); // Emit positional-argument construction errors when enabled.
    exit(1); // Stop because the target function cannot be called with the collected/defaulted argument sequence.
} // End the positional-argument construction failure branch.

$var_5c2040b1_invocation_arr = fun_6bd31470_invoke_target_function_i1790960242_v2($var_5c2040b1_definition_arr['name'], $var_5c2040b1_positional_arr['arguments']); // Invoke the selected function while capturing its ordinary output and rendered return value.
if ($var_5c2040b1_invocation_arr['success'] === FALSE) { // Check whether the target function threw an exception or otherwise failed during invocation.
    if ($var_5c2040b1_display_output_boo === TRUE) { // Check whether captured ordinary output should be reproduced.
        echo $var_5c2040b1_load_arr['include_output']; // Output text emitted while loading the target file.
        echo $var_5c2040b1_invocation_arr['output']; // Output text emitted by the target function before it failed.
    } // End the captured ordinary-output branch.
    fun_78ee7f42_emit_errors_i1790960242_v2(array($var_5c2040b1_invocation_arr['error']), $var_5c2040b1_display_errors_boo); // Emit the target-function failure when enabled.
    exit(1); // Stop with failure because invocation did not complete successfully.
} // End the target-function invocation failure branch.

if ($var_5c2040b1_display_output_boo === TRUE) { // Check whether normal output is enabled after a successful invocation.
    echo $var_5c2040b1_load_arr['include_output']; // Output any text emitted while the target PHP file was loaded.
    echo $var_5c2040b1_invocation_arr['output']; // Output any text emitted directly by the target function.
    echo $var_5c2040b1_invocation_arr['rendered_return']; // Output the target function's return value in the application's readable rendering format.
} // End the successful ordinary-output branch.
exit(0); // End the application successfully after the target function completes.
