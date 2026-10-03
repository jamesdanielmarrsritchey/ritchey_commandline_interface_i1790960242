<?php
// Description: Converts a PHP return value into deterministic plain-text suitable for command-line output.
declare(strict_types=1); // Enable strict type checking for this source file.

function fun_67dd6e31_render_value_i1790960242_v2($var_67dd6e31_value_uns) // Render a target function's return value as plain-text.
{ // Start the return-value rendering function.
    if ($var_67dd6e31_value_uns === NULL) { // Check whether the target function returned no value.
        return ''; // Return no text for a NULL function result.
    } // End the NULL result check.
    if (is_bool($var_67dd6e31_value_uns) === TRUE) { // Check whether the target function returned a boolean.
        return $var_67dd6e31_value_uns === TRUE ? 'TRUE' . PHP_EOL : 'FALSE' . PHP_EOL; // Render boolean values explicitly and append a line ending.
    } // End the boolean result check.
    if (is_string($var_67dd6e31_value_uns) === TRUE || is_int($var_67dd6e31_value_uns) === TRUE || is_float($var_67dd6e31_value_uns) === TRUE) { // Check whether the result is directly representable as a scalar string.
        return (string) $var_67dd6e31_value_uns . PHP_EOL; // Render the scalar result followed by a line ending.
    } // End the scalar result check.
    if (is_array($var_67dd6e31_value_uns) === TRUE || is_object($var_67dd6e31_value_uns) === TRUE) { // Check whether the result can be usefully represented as JSON.
        $var_67dd6e31_json_uns = json_encode($var_67dd6e31_value_uns, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); // Encode arrays and objects as readable JSON.
        if ($var_67dd6e31_json_uns !== FALSE) { // Check whether JSON encoding succeeded.
            return $var_67dd6e31_json_uns . PHP_EOL; // Return the readable JSON representation followed by a line ending.
        } // End the successful JSON encoding check.
    } // End the JSON-compatible result check.
    return var_export($var_67dd6e31_value_uns, TRUE) . PHP_EOL; // Fall back to PHP's textual export representation for unusual return types.
} // End the return-value rendering function.
