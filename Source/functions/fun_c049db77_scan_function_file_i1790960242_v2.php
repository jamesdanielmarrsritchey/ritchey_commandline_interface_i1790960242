<?php
// Description: Scans PHP source code for global named functions that have Ritchey PARAMETERS declarations immediately preceding them.
declare(strict_types=1); // Enable strict type checking for this source file.

function fun_c049db77_scan_function_file_i1790960242_v2($var_c049db77_source_str) // Discover compatible global functions and parse their declared parameter metadata.
{ // Start the PHP function-file scanning function.
    if (is_string($var_c049db77_source_str) === FALSE) { // Validate source input before passing it to the tokenizer.
        return array(); // Return no compatible functions for malformed source input.
    } // End the source-input validation check.
    $var_c049db77_tokens_arr = token_get_all($var_c049db77_source_str); // Tokenize the PHP source using PHP's built-in parser-aware tokenizer.
    $var_c049db77_definitions_arr = array(); // Create storage for compatible function definitions discovered in the source file.
    $var_c049db77_pending_comment_uns = NULL; // Store a PARAMETERS comment until the next eligible global named function is found.
    $var_c049db77_brace_depth_num = 0; // Track the current curly-brace nesting depth.
    $var_c049db77_class_depths_arr = array(); // Track brace depths belonging to class-like declarations so methods are not treated as global functions.
    $var_c049db77_class_pending_boo = FALSE; // Track whether a class-like declaration is waiting for its opening brace.
    $var_c049db77_count_num = count($var_c049db77_tokens_arr); // Count the tokenizer output entries.
    for ($var_c049db77_index_num = 0; $var_c049db77_index_num < $var_c049db77_count_num; $var_c049db77_index_num++) { // Iterate over every PHP token.
        $var_c049db77_token_uns = $var_c049db77_tokens_arr[$var_c049db77_index_num]; // Read the current tokenizer entry.
        if (is_string($var_c049db77_token_uns) === TRUE) { // Check whether the tokenizer entry is a one-character syntax token.
            if ($var_c049db77_token_uns === '{') { // Check for an opening curly brace.
                $var_c049db77_brace_depth_num++; // Increase the current brace nesting depth.
                if ($var_c049db77_class_pending_boo === TRUE) { // Check whether this brace opens a class-like declaration.
                    $var_c049db77_class_depths_arr[] = $var_c049db77_brace_depth_num; // Record the class-like declaration's brace depth.
                    $var_c049db77_class_pending_boo = FALSE; // Clear the pending class-like declaration marker.
                    $var_c049db77_pending_comment_uns = NULL; // Prevent a declaration comment outside the class from leaking into a method.
                } // End the class-opening-brace check.
            } elseif ($var_c049db77_token_uns === '}') { // Check for a closing curly brace.
                $var_c049db77_last_class_depth_uns = end($var_c049db77_class_depths_arr); // Read the most recent class-like brace depth when one exists.
                if ($var_c049db77_last_class_depth_uns !== FALSE && (int) $var_c049db77_last_class_depth_uns === $var_c049db77_brace_depth_num) { // Check whether this brace closes the active class-like declaration.
                    array_pop($var_c049db77_class_depths_arr); // Remove the closed class-like declaration from the depth stack.
                } // End the class-closing-brace check.
                if ($var_c049db77_brace_depth_num > 0) { // Check that brace depth can be safely decreased.
                    $var_c049db77_brace_depth_num--; // Decrease the current brace nesting depth.
                } // End the safe brace-depth decrease check.
            } // End the syntax-token brace handling.
            continue; // Continue to the next tokenizer entry.
        } // End the one-character syntax token check.
        $var_c049db77_token_id_num = $var_c049db77_token_uns[0]; // Read the numeric tokenizer identifier.
        $var_c049db77_token_text_str = $var_c049db77_token_uns[1]; // Read the source text represented by the tokenizer entry.
        if ($var_c049db77_token_id_num === T_CLASS || $var_c049db77_token_id_num === T_INTERFACE || $var_c049db77_token_id_num === T_TRAIT || (defined('T_ENUM') === TRUE && $var_c049db77_token_id_num === T_ENUM)) { // Check for the start of a class-like declaration.
            $var_c049db77_class_pending_boo = TRUE; // Mark the next opening brace as a class-like declaration boundary.
            $var_c049db77_pending_comment_uns = NULL; // Clear any pending global PARAMETERS comment before entering a class-like declaration.
            continue; // Continue scanning the remaining tokenizer entries.
        } // End the class-like declaration check.
        if (($var_c049db77_token_id_num === T_COMMENT || $var_c049db77_token_id_num === T_DOC_COMMENT) && count($var_c049db77_class_depths_arr) === 0) { // Check for a global comment token outside class-like declarations.
            if (str_contains($var_c049db77_token_text_str, 'PARAMETERS:') === TRUE) { // Check whether the comment contains the formal PARAMETERS label.
                $var_c049db77_pending_comment_uns = $var_c049db77_token_text_str; // Store the declaration comment for the next global named function.
            } // End the PARAMETERS-comment detection check.
            continue; // Continue scanning the remaining tokenizer entries.
        } // End the global comment-token check.
        if ($var_c049db77_token_id_num === T_FUNCTION && count($var_c049db77_class_depths_arr) === 0) { // Check for a global function declaration.
            $var_c049db77_function_name_uns = NULL; // Prepare storage for the named function discovered after the function keyword.
            for ($var_c049db77_name_index_num = $var_c049db77_index_num + 1; $var_c049db77_name_index_num < $var_c049db77_count_num; $var_c049db77_name_index_num++) { // Scan forward until the function name or parameter opening parenthesis is reached.
                $var_c049db77_name_token_uns = $var_c049db77_tokens_arr[$var_c049db77_name_index_num]; // Read the candidate function-name token.
                if (is_string($var_c049db77_name_token_uns) === TRUE && $var_c049db77_name_token_uns === '(') { // Check whether this is an anonymous function with no name token.
                    break; // Stop scanning because anonymous functions are not supported targets.
                } // End the anonymous-function boundary check.
                if (is_array($var_c049db77_name_token_uns) === TRUE && $var_c049db77_name_token_uns[0] === T_STRING) { // Check whether the candidate token is a function name.
                    $var_c049db77_function_name_uns = $var_c049db77_name_token_uns[1]; // Store the discovered global function name.
                    break; // Stop scanning once the function name has been found.
                } // End the named-function token check.
            } // End the function-name scanning loop.
            if ($var_c049db77_function_name_uns !== NULL && is_string($var_c049db77_pending_comment_uns) === TRUE) { // Check whether a named global function has a pending PARAMETERS declaration.
                $var_c049db77_parsed_arr = fun_b83e90af_parse_parameter_declaration_i1790960242_v2($var_c049db77_pending_comment_uns); // Parse and validate the function's declaration comment.
                $var_c049db77_definitions_arr[] = array('name' => $var_c049db77_function_name_uns, 'parameters' => $var_c049db77_parsed_arr['parameters'], 'errors' => $var_c049db77_parsed_arr['errors']); // Store the discovered compatible function definition.
            } // End the compatible named-function check.
            $var_c049db77_pending_comment_uns = NULL; // Clear the pending declaration so it cannot be associated with another function.
        } // End the global-function declaration check.
    } // End the tokenizer loop.
    return $var_c049db77_definitions_arr; // Return all compatible global function definitions discovered in the source file.
} // End the PHP function-file scanning function.
