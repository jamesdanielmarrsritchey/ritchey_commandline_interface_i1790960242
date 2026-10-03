<?php
// Description: Converts supported boolean option values into a PHP boolean value.
declare(strict_types=1);

function fun_e62b0a4d_convert_boolean_i1790960242_v2($var_e62b0a4d_value_uns)
{
    if (is_bool($var_e62b0a4d_value_uns) === TRUE) {
        return array('success' => TRUE, 'value' => $var_e62b0a4d_value_uns, 'error' => '');
    } elseif (is_string($var_e62b0a4d_value_uns) === FALSE) {
        return array('success' => FALSE, 'value' => NULL, 'error' => 'Expected a boolean value: true, TRUE, t, false, FALSE, or f.');
    }

    $var_e62b0a4d_normalized_str = strtolower($var_e62b0a4d_value_uns);
    if ($var_e62b0a4d_normalized_str === 'true' || $var_e62b0a4d_normalized_str === 't') {
        return array('success' => TRUE, 'value' => TRUE, 'error' => '');
    } elseif ($var_e62b0a4d_normalized_str === 'false' || $var_e62b0a4d_normalized_str === 'f') {
        return array('success' => TRUE, 'value' => FALSE, 'error' => '');
    } else {
        return array('success' => FALSE, 'value' => NULL, 'error' => 'Expected a boolean value: true, TRUE, t, false, FALSE, or f.');
    }
}
