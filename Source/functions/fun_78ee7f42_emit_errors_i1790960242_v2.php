<?php
// Description: Writes one or more application errors to STDERR when error display is enabled.
declare(strict_types=1);

function fun_78ee7f42_emit_errors_i1790960242_v2($var_78ee7f42_errors_uns, $var_78ee7f42_display_errors_uns)
{
    if (is_bool($var_78ee7f42_display_errors_uns) === FALSE) {
        $var_78ee7f42_display_errors_boo = TRUE;
    } else {
        $var_78ee7f42_display_errors_boo = $var_78ee7f42_display_errors_uns;
    }

    if ($var_78ee7f42_display_errors_boo === FALSE) {
        return;
    }

    if (is_array($var_78ee7f42_errors_uns) === FALSE) {
        $var_78ee7f42_errors_arr = array($var_78ee7f42_errors_uns);
    } else {
        $var_78ee7f42_errors_arr = $var_78ee7f42_errors_uns;
    }

    foreach ($var_78ee7f42_errors_arr as $var_78ee7f42_error_uns) {
        fwrite(STDERR, 'Error: ' . (string) $var_78ee7f42_error_uns . PHP_EOL);
    }
}
