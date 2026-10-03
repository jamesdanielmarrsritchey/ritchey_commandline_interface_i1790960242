<?php
// Description: Uses PHP Reflection inside a functional wrapper to verify that a loaded function is compatible with its ordered PARAMETERS metadata.
declare(strict_types=1); // Enable strict type checking for this source file.

function fun_56cc5c20_inspect_loaded_function_i1790960242_v2($var_56cc5c20_function_name_str, $var_56cc5c20_declared_parameters_arr) // Validate the loaded function signature and return actual PHP type/default information aligned to public declaration names.
{ // Start the loaded-function inspection function.
    if (is_string($var_56cc5c20_function_name_str) === FALSE || is_array($var_56cc5c20_declared_parameters_arr) === FALSE) { // Validate the wrapper inputs before using Reflection.
        return array('success' => FALSE, 'errors' => array('The function name must be a string and the declared parameters must be an array.'), 'actual_types' => array(), 'defaults' => array()); // Return a normal contract failure instead of relying on a PHP signature TypeError.
    } // End the wrapper-input validation check.
    $var_56cc5c20_errors_arr = array(); // Create storage for function contract errors.
    $var_56cc5c20_actual_types_arr = array(); // Create storage for actual PHP parameter type declarations keyed by public declaration name.
    $var_56cc5c20_defaults_arr = array(); // Create storage for actual PHP default values keyed by public declaration name.
    if (function_exists($var_56cc5c20_function_name_str) === FALSE) { // Check whether loading the source file actually defined the selected function.
        return array('success' => FALSE, 'errors' => array('The selected function was not defined after loading the supplied source file: ' . $var_56cc5c20_function_name_str), 'actual_types' => array(), 'defaults' => array()); // Return an immediate contract failure when the function is absent.
    } // End the loaded-function existence check.
    $var_56cc5c20_reflection_obj = new ReflectionFunction($var_56cc5c20_function_name_str); // Create PHP reflection metadata for the selected global function.
    $var_56cc5c20_reflection_parameters_arr = $var_56cc5c20_reflection_obj->getParameters(); // Read the actual function parameter definitions in declaration order.
    $var_56cc5c20_declared_parameter_values_arr = array_values($var_56cc5c20_declared_parameters_arr); // Convert associative public parameter metadata to an ordered numeric list.
    if (count($var_56cc5c20_reflection_parameters_arr) !== count($var_56cc5c20_declared_parameter_values_arr)) { // Check whether metadata and PHP function signature contain the same number of parameters.
        $var_56cc5c20_errors_arr[] = 'The PARAMETERS declaration contains ' . count($var_56cc5c20_declared_parameter_values_arr) . ' parameter(s), but the PHP function signature contains ' . count($var_56cc5c20_reflection_parameters_arr) . ' parameter(s).'; // Record the parameter-count contract mismatch.
    } // End the parameter-count contract check.
    $var_56cc5c20_pair_count_num = min(count($var_56cc5c20_reflection_parameters_arr), count($var_56cc5c20_declared_parameter_values_arr)); // Determine how many ordered parameter pairs can safely be validated.
    for ($var_56cc5c20_index_num = 0; $var_56cc5c20_index_num < $var_56cc5c20_pair_count_num; $var_56cc5c20_index_num++) { // Iterate over aligned declared and actual parameters by position.
        $var_56cc5c20_parameter_obj = $var_56cc5c20_reflection_parameters_arr[$var_56cc5c20_index_num]; // Read the actual PHP parameter at the current position.
        $var_56cc5c20_declared_parameter_arr = $var_56cc5c20_declared_parameter_values_arr[$var_56cc5c20_index_num]; // Read the public declaration parameter at the same position.
        $var_56cc5c20_public_name_str = $var_56cc5c20_declared_parameter_arr['name']; // Read the public command-line parameter name from the declaration metadata.
        if ($var_56cc5c20_parameter_obj->isPassedByReference() === TRUE) { // Check whether the parameter requires pass-by-reference semantics.
            $var_56cc5c20_errors_arr[] = 'Parameter --' . $var_56cc5c20_public_name_str . ' maps to a PHP parameter passed by reference, which is not supported by this Commandline Interface release.'; // Record the unsupported pass-by-reference parameter.
        } // End the pass-by-reference check.
        if ($var_56cc5c20_parameter_obj->isVariadic() === TRUE) { // Check whether the parameter is variadic.
            $var_56cc5c20_errors_arr[] = 'Parameter --' . $var_56cc5c20_public_name_str . ' maps to a variadic PHP parameter, which is not supported by this Commandline Interface release.'; // Record the unsupported variadic parameter.
        } // End the variadic-parameter check.
        $var_56cc5c20_declared_status_str = $var_56cc5c20_declared_parameter_arr['status']; // Read the declared required/optional state.
        if ($var_56cc5c20_declared_status_str === 'optional' && $var_56cc5c20_parameter_obj->isOptional() === FALSE) { // Check whether metadata says optional while PHP requires the argument.
            $var_56cc5c20_errors_arr[] = 'Parameter --' . $var_56cc5c20_public_name_str . ' is declared optional but the PHP parameter at the same position is not optional/defaulted.'; // Record the optional-state contract mismatch.
        } // End the optional-state contract check.
        if ($var_56cc5c20_parameter_obj->isDefaultValueAvailable() === TRUE) { // Check whether the PHP parameter provides a default value that can be used when an earlier optional CLI parameter is omitted.
            $var_56cc5c20_defaults_arr[$var_56cc5c20_public_name_str] = array('available' => TRUE, 'value' => $var_56cc5c20_parameter_obj->getDefaultValue()); // Store the actual PHP default value for positional invocation filling.
        } else { // Handle PHP parameters that do not provide a default value.
            $var_56cc5c20_defaults_arr[$var_56cc5c20_public_name_str] = array('available' => FALSE, 'value' => NULL); // Record that no default value is available for this public parameter position.
        } // End the PHP default-value availability branch.
        $var_56cc5c20_type_obj = $var_56cc5c20_parameter_obj->getType(); // Read the actual PHP type declaration when one exists.
        $var_56cc5c20_type_str = $var_56cc5c20_type_obj === NULL ? '' : (string) $var_56cc5c20_type_obj; // Convert the actual PHP type declaration into a comparable string.
        $var_56cc5c20_actual_types_arr[$var_56cc5c20_public_name_str] = $var_56cc5c20_type_str; // Store the actual PHP type declaration using the public CLI parameter name.
        if ($var_56cc5c20_type_str !== '') { // Check whether the actual PHP parameter has an explicit type declaration.
            $var_56cc5c20_type_check_str = ltrim($var_56cc5c20_type_str, '?'); // Remove nullable shorthand so the underlying PHP type can be compared.
            if (str_contains($var_56cc5c20_type_check_str, '&') === TRUE) { // Check whether the function uses an intersection type unsupported by this release.
                $var_56cc5c20_errors_arr[] = 'Parameter --' . $var_56cc5c20_public_name_str . ' maps to an intersection PHP type, which is not supported by this Commandline Interface release.'; // Record the unsupported intersection type.
            } else { // Continue compatibility checking for simple and union PHP types.
                $var_56cc5c20_union_types_arr = explode('|', $var_56cc5c20_type_check_str); // Split a PHP union type into individual type names.
                $var_56cc5c20_declared_type_str = $var_56cc5c20_declared_parameter_arr['type']; // Read the PARAMETERS declaration type.
                $var_56cc5c20_allowed_php_types_arr = array(); // Prepare the PHP type names compatible with the declared metadata type.
                if ($var_56cc5c20_declared_type_str === 'string' || $var_56cc5c20_declared_type_str === 'file' || $var_56cc5c20_declared_type_str === 'folder') { // Check for declaration types represented as PHP strings.
                    $var_56cc5c20_allowed_php_types_arr = array('string', 'mixed'); // Permit PHP string or mixed declarations.
                } elseif ($var_56cc5c20_declared_type_str === 'boolean') { // Check for the declaration boolean type.
                    $var_56cc5c20_allowed_php_types_arr = array('bool', 'true', 'false', 'mixed'); // Permit PHP boolean-compatible type declarations.
                } elseif ($var_56cc5c20_declared_type_str === 'number') { // Check for the declaration number type.
                    $var_56cc5c20_allowed_php_types_arr = array('int', 'float', 'mixed'); // Permit PHP integer, float, or mixed numeric declarations.
                } elseif ($var_56cc5c20_declared_type_str === 'array') { // Check for the declaration array type.
                    $var_56cc5c20_allowed_php_types_arr = array('array', 'mixed'); // Permit PHP array or mixed declarations.
                } // End the declared-type to PHP-type mapping.
                $var_56cc5c20_compatible_boo = FALSE; // Track whether at least one actual PHP union member matches the declared metadata type.
                foreach ($var_56cc5c20_union_types_arr as $var_56cc5c20_union_type_str) { // Iterate over each actual PHP type member.
                    if ($var_56cc5c20_union_type_str === 'null') { // Check for an explicit nullable union member.
                        continue; // Ignore nullability for declaration-type compatibility.
                    } // End the explicit null member check.
                    if (in_array($var_56cc5c20_union_type_str, $var_56cc5c20_allowed_php_types_arr, TRUE) === TRUE) { // Check whether this PHP type member is compatible with the metadata type.
                        $var_56cc5c20_compatible_boo = TRUE; // Mark the actual type declaration as compatible.
                    } // End the compatible union-member check.
                } // End the actual PHP union-type loop.
                if ($var_56cc5c20_compatible_boo === FALSE) { // Check whether no actual PHP type member matched the PARAMETERS declaration.
                    $var_56cc5c20_errors_arr[] = 'Parameter --' . $var_56cc5c20_public_name_str . ' is declared as ' . $var_56cc5c20_declared_type_str . ' but the PHP parameter at the same position has type ' . $var_56cc5c20_type_str . '.'; // Record the metadata-to-signature type mismatch.
                } // End the declaration/signature type compatibility check.
            } // End the supported actual PHP type branch.
        } // End the explicit actual PHP type check.
    } // End the aligned parameter-pair loop.
    return array('success' => count($var_56cc5c20_errors_arr) === 0, 'errors' => $var_56cc5c20_errors_arr, 'actual_types' => $var_56cc5c20_actual_types_arr, 'defaults' => $var_56cc5c20_defaults_arr); // Return the complete contract-inspection result.
} // End the loaded-function inspection function.
