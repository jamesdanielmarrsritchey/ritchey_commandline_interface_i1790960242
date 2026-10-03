<?php
// Description: Validates a converted function argument against the actual PHP parameter type before the target function is called.
declare(strict_types=1); // Enable strict type checking for this source file.

function fun_8a0f9153_validate_value_php_type_i1790960242_v2($var_8a0f9153_value_uns, $var_8a0f9153_php_type_str) // Determine whether a converted value satisfies an actual PHP parameter type declaration.
{ // Start the actual-PHP-type validation function.
    if (is_string($var_8a0f9153_php_type_str) === FALSE) { // Validate the PHP type description before string operations are used.
        return FALSE; // Reject malformed contract data instead of relying on a PHP signature TypeError.
    } // End the PHP type-description validation check.
    if ($var_8a0f9153_php_type_str === '' || $var_8a0f9153_php_type_str === 'mixed') { // Check whether the PHP signature places no meaningful type restriction on the value.
        return TRUE; // Accept the converted value because there is no restrictive PHP type declaration.
    } // End the unrestricted type check.
    $var_8a0f9153_nullable_boo = str_starts_with($var_8a0f9153_php_type_str, '?'); // Detect nullable shorthand in the PHP parameter type.
    $var_8a0f9153_type_check_str = ltrim($var_8a0f9153_php_type_str, '?'); // Remove nullable shorthand before checking individual type names.
    $var_8a0f9153_types_arr = explode('|', $var_8a0f9153_type_check_str); // Split a union type into individual PHP type names.
    if ($var_8a0f9153_value_uns === NULL && ($var_8a0f9153_nullable_boo === TRUE || in_array('null', $var_8a0f9153_types_arr, TRUE) === TRUE)) { // Check whether a null value is explicitly permitted.
        return TRUE; // Accept the null value when the actual PHP signature permits it.
    } // End the permitted-null check.
    foreach ($var_8a0f9153_types_arr as $var_8a0f9153_type_str) { // Iterate over each PHP union-type member.
        if ($var_8a0f9153_type_str === 'mixed') { // Check whether the union includes mixed.
            return TRUE; // Accept any converted value when mixed is allowed.
        } // End the mixed-type check.
        if ($var_8a0f9153_type_str === 'string' && is_string($var_8a0f9153_value_uns) === TRUE) { // Check for a string-compatible value.
            return TRUE; // Accept the string value.
        } // End the string-value check.
        if ($var_8a0f9153_type_str === 'bool' && is_bool($var_8a0f9153_value_uns) === TRUE) { // Check for a boolean-compatible value.
            return TRUE; // Accept the boolean value.
        } // End the boolean-value check.
        if ($var_8a0f9153_type_str === 'true' && $var_8a0f9153_value_uns === TRUE) { // Check for the PHP literal TRUE type.
            return TRUE; // Accept the TRUE value.
        } // End the literal TRUE check.
        if ($var_8a0f9153_type_str === 'false' && $var_8a0f9153_value_uns === FALSE) { // Check for the PHP literal FALSE type.
            return TRUE; // Accept the FALSE value.
        } // End the literal FALSE check.
        if ($var_8a0f9153_type_str === 'int' && is_int($var_8a0f9153_value_uns) === TRUE) { // Check for an integer-compatible value.
            return TRUE; // Accept the integer value.
        } // End the integer-value check.
        if ($var_8a0f9153_type_str === 'float' && (is_float($var_8a0f9153_value_uns) === TRUE || is_int($var_8a0f9153_value_uns) === TRUE)) { // Check for a strict-mode float-compatible value, including PHP's permitted integer-to-float widening.
            return TRUE; // Accept the float-compatible numeric value.
        } // End the float-value check.
        if ($var_8a0f9153_type_str === 'array' && is_array($var_8a0f9153_value_uns) === TRUE) { // Check for an array-compatible value.
            return TRUE; // Accept the array value.
        } // End the array-value check.
    } // End the PHP union-type loop.
    return FALSE; // Reject the value when it matches none of the actual PHP parameter types.
} // End the actual-PHP-type validation function.
