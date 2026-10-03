<?php
// Description: Parses one PARAMETERS comment that follows the Ritchey PHP Function Parameter Declaration Format v1.
declare(strict_types=1); // Enable strict type checking for this source file.

function fun_b83e90af_parse_parameter_declaration_i1790960242_v2($var_b83e90af_comment_str) // Parse a PARAMETERS comment into validated parameter metadata.
{ // Start the parameter-declaration parsing function.
    if (is_string($var_b83e90af_comment_str) === FALSE) { // Validate declaration input before line parsing.
        return array('parameters' => array(), 'errors' => array('The PARAMETERS declaration must be a string.')); // Return a normal parsing error instead of relying on a PHP signature TypeError.
    } // End the declaration-input validation check.
    $var_b83e90af_parameters_arr = array(); // Create storage for parsed parameter declarations.
    $var_b83e90af_errors_arr = array(); // Create storage for declaration-format errors.
    $var_b83e90af_allowed_statuses_arr = array('required', 'optional'); // Define the supported required-state values.
    $var_b83e90af_allowed_types_arr = array('number', 'array', 'string', 'boolean', 'file', 'folder'); // Define the parameter types specified by the declaration format.
    $var_b83e90af_lines_arr = preg_split('/\R/', $var_b83e90af_comment_str); // Split the comment into individual lines.
    if ($var_b83e90af_lines_arr === FALSE) { // Check whether line splitting unexpectedly failed.
        return array('parameters' => array(), 'errors' => array('Could not split the PARAMETERS declaration into lines.')); // Return a declaration parsing failure.
    } // End the line-splitting failure check.
    $var_b83e90af_in_parameters_boo = FALSE; // Track whether the PARAMETERS section has started.
    foreach ($var_b83e90af_lines_arr as $var_b83e90af_line_uns) { // Iterate over every line in the declaration comment.
        $var_b83e90af_line_str = trim((string) $var_b83e90af_line_uns); // Normalize surrounding whitespace on the current line.
        $var_b83e90af_line_str = preg_replace('/^\/\*+\s*/', '', $var_b83e90af_line_str) ?? $var_b83e90af_line_str; // Remove an opening block-comment marker from the line when present.
        $var_b83e90af_line_str = preg_replace('/\s*\*\/$/', '', $var_b83e90af_line_str) ?? $var_b83e90af_line_str; // Remove a closing block-comment marker from the line when present.
        $var_b83e90af_line_str = preg_replace('/^\*\s?/', '', $var_b83e90af_line_str) ?? $var_b83e90af_line_str; // Remove a documentation-comment leading asterisk when present.
        $var_b83e90af_line_str = trim($var_b83e90af_line_str); // Normalize the line again after comment-marker removal.
        if ($var_b83e90af_line_str === 'PARAMETERS:') { // Check for the exact PARAMETERS section label.
            $var_b83e90af_in_parameters_boo = TRUE; // Mark the parser as being inside the parameter declaration section.
            continue; // Continue to the next line where parameter list entries may begin.
        } // End the PARAMETERS label check.
        if ($var_b83e90af_in_parameters_boo === FALSE) { // Check whether the PARAMETERS label has not yet been reached.
            continue; // Ignore descriptive comment text outside the PARAMETERS section.
        } // End the pre-PARAMETERS text check.
        if ($var_b83e90af_line_str === '') { // Check for a blank line inside or after the PARAMETERS section.
            continue; // Ignore blank lines without changing parser state.
        } // End the blank-line check.
        if (str_starts_with($var_b83e90af_line_str, '- ') === FALSE) { // Check whether the line is not a Ritchey Markup Language dot-list entry.
            break; // End parameter parsing when non-list content begins after the PARAMETERS label.
        } // End the list-entry check.
        $var_b83e90af_entry_str = substr($var_b83e90af_line_str, 2); // Remove the dot-list prefix from the parameter entry.
        $var_b83e90af_parts_arr = array_map('trim', explode(',', $var_b83e90af_entry_str)); // Split the parameter entry into comma-separated fields and trim each field.
        if (count($var_b83e90af_parts_arr) !== 3) { // Check whether exactly three declaration fields were supplied.
            $var_b83e90af_errors_arr[] = 'Invalid parameter declaration entry: ' . $var_b83e90af_line_str; // Record the malformed declaration entry.
            continue; // Continue parsing later declaration entries.
        } // End the declaration-field-count check.
        $var_b83e90af_name_str = $var_b83e90af_parts_arr[0]; // Read the declared parameter name.
        $var_b83e90af_status_str = strtolower($var_b83e90af_parts_arr[1]); // Normalize the required/optional field.
        $var_b83e90af_type_str = strtolower($var_b83e90af_parts_arr[2]); // Normalize the declared type field.
        if (preg_match('/^[a-z][a-z0-9_]*$/', $var_b83e90af_name_str) !== 1) { // Check whether the parameter name follows the lowercase option naming convention.
            $var_b83e90af_errors_arr[] = 'Invalid parameter name in declaration: ' . $var_b83e90af_name_str; // Record the invalid parameter name.
            continue; // Continue parsing later declaration entries.
        } // End the parameter-name validation check.
        if (isset($var_b83e90af_parameters_arr[$var_b83e90af_name_str]) === TRUE) { // Check whether the declaration repeats a parameter name.
            $var_b83e90af_errors_arr[] = 'Duplicate parameter declaration: ' . $var_b83e90af_name_str; // Record the duplicate parameter declaration.
            continue; // Continue parsing later declaration entries.
        } // End the duplicate-parameter check.
        if (in_array($var_b83e90af_status_str, $var_b83e90af_allowed_statuses_arr, TRUE) === FALSE) { // Check whether the required-state field is supported.
            $var_b83e90af_errors_arr[] = 'Invalid required/optional value for parameter ' . $var_b83e90af_name_str . ': ' . $var_b83e90af_status_str; // Record the unsupported required-state value.
            continue; // Continue parsing later declaration entries.
        } // End the required-state validation check.
        if (in_array($var_b83e90af_type_str, $var_b83e90af_allowed_types_arr, TRUE) === FALSE) { // Check whether the declared type is supported by the parameter declaration format.
            $var_b83e90af_errors_arr[] = 'Invalid type for parameter ' . $var_b83e90af_name_str . ': ' . $var_b83e90af_type_str; // Record the unsupported parameter type.
            continue; // Continue parsing later declaration entries.
        } // End the parameter-type validation check.
        $var_b83e90af_parameters_arr[$var_b83e90af_name_str] = array('name' => $var_b83e90af_name_str, 'status' => $var_b83e90af_status_str, 'type' => $var_b83e90af_type_str); // Store the validated parameter declaration keyed by its command-line option name.
    } // End the declaration-line loop.
    if ($var_b83e90af_in_parameters_boo === FALSE) { // Check whether the required PARAMETERS label was absent.
        $var_b83e90af_errors_arr[] = 'The declaration comment does not contain a PARAMETERS: label.'; // Record the missing declaration label.
    } // End the PARAMETERS-label presence check.
    return array('parameters' => $var_b83e90af_parameters_arr, 'errors' => $var_b83e90af_errors_arr); // Return the parsed parameter metadata and any validation errors.
} // End the parameter-declaration parsing function.
