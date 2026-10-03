<?php
// Description: Hashes one file or a comma-separated list of files with one or more PHP-supported hashing algorithms.
declare(strict_types=1); // Enable strict type checking for this source file.

/*
PARAMETERS:
- source_files, required, string
- algorithms, optional, string
*/
function fun_4d7e9c21_hash_files_i1790960242_v2($var_4d7e9c21_source_files_uns, $var_4d7e9c21_algorithms_uns = 'sha256,sha512,sha3-256,sha3-512') // Hash the requested files and return checksums grouped under algorithm keys.
{ // Start the file hashing function.
    if (is_string($var_4d7e9c21_source_files_uns) === FALSE) { // Check whether the public source_files value is a string before string parsing is attempted.
        throw new InvalidArgumentException('source_files must be a string containing one file path or a comma-separated list of file paths.'); // Stop when an incompatible value reaches the function.
    } else { // Handle a valid source_files input type.
        $var_4d7e9c21_source_files_str = $var_4d7e9c21_source_files_uns; // Store the validated source_files string for parsing.
    } // End the source_files type check.
    if (is_string($var_4d7e9c21_algorithms_uns) === FALSE) { // Check whether the public algorithms value is a string before string parsing is attempted.
        throw new InvalidArgumentException('algorithms must be a string containing one algorithm or a comma-separated list of algorithms.'); // Stop when an incompatible value reaches the function.
    } else { // Handle a valid algorithms input type.
        $var_4d7e9c21_algorithms_str = $var_4d7e9c21_algorithms_uns; // Store the validated algorithms string for parsing.
    } // End the algorithms type check.

    $var_4d7e9c21_source_files_arr = array(); // Create storage for normalized source-file paths.
    $var_4d7e9c21_source_file_parts_arr = explode(',', $var_4d7e9c21_source_files_str); // Split the supplied file string so a single path or comma-separated path list can be accepted.
    foreach ($var_4d7e9c21_source_file_parts_arr as $var_4d7e9c21_source_file_part_str) { // Process each supplied source-file entry.
        $var_4d7e9c21_source_file_str = trim($var_4d7e9c21_source_file_part_str); // Remove surrounding whitespace from the current file path.
        if ($var_4d7e9c21_source_file_str === '') { // Check whether this list item became empty after trimming.
            continue; // Ignore empty list items so incidental whitespace or repeated commas do not become file paths.
        } // End the empty source-file item check.
        $var_4d7e9c21_source_files_arr[] = $var_4d7e9c21_source_file_str; // Store the normalized source-file path in its original order.
    } // End the source-file parsing loop.
    if (count($var_4d7e9c21_source_files_arr) === 0) { // Check whether at least one usable source-file path was supplied.
        throw new InvalidArgumentException('At least one source file path must be supplied.'); // Stop execution when no source files were provided.
    } // End the missing source-file check.

    $var_4d7e9c21_algorithms_arr = array(); // Create storage for normalized hashing algorithm names.
    $var_4d7e9c21_algorithm_parts_arr = explode(',', $var_4d7e9c21_algorithms_str); // Split the algorithm string so one or several algorithms can be requested.
    $var_4d7e9c21_supported_algorithms_arr = hash_algos(); // Read the hashing algorithms supported by the installed PHP runtime.
    foreach ($var_4d7e9c21_algorithm_parts_arr as $var_4d7e9c21_algorithm_part_str) { // Process each supplied algorithm entry.
        $var_4d7e9c21_algorithm_str = strtolower(trim($var_4d7e9c21_algorithm_part_str)); // Normalize the current algorithm name for comparison and output keys.
        if ($var_4d7e9c21_algorithm_str === '') { // Check whether this algorithm list item became empty after trimming.
            continue; // Ignore empty list items.
        } // End the empty algorithm item check.
        if (in_array($var_4d7e9c21_algorithm_str, $var_4d7e9c21_supported_algorithms_arr, TRUE) === FALSE) { // Check whether PHP supports the requested algorithm.
            throw new InvalidArgumentException('Unsupported hashing algorithm: ' . $var_4d7e9c21_algorithm_str); // Stop execution when an unsupported algorithm is requested.
        } // End the hashing-algorithm support check.
        if (in_array($var_4d7e9c21_algorithm_str, $var_4d7e9c21_algorithms_arr, TRUE) === FALSE) { // Check whether this algorithm has already been requested.
            $var_4d7e9c21_algorithms_arr[] = $var_4d7e9c21_algorithm_str; // Store each algorithm only once while preserving request order.
        } // End the duplicate algorithm check.
    } // End the algorithm parsing loop.
    if (count($var_4d7e9c21_algorithms_arr) === 0) { // Check whether at least one usable hashing algorithm remains.
        throw new InvalidArgumentException('At least one hashing algorithm must be supplied.'); // Stop execution when the algorithm list is empty.
    } // End the missing algorithm check.

    foreach ($var_4d7e9c21_source_files_arr as $var_4d7e9c21_source_file_str) { // Validate every requested source file before hashing begins.
        if (is_file($var_4d7e9c21_source_file_str) === FALSE) { // Check whether the path identifies an existing regular file that can be hashed.
            throw new InvalidArgumentException('Source file does not exist or is not a regular file: ' . $var_4d7e9c21_source_file_str); // Stop execution when a requested input file cannot be used.
        } // End the regular-file validation check.
        if (is_readable($var_4d7e9c21_source_file_str) === FALSE) { // Check whether PHP can read the requested source file.
            throw new InvalidArgumentException('Source file is not readable: ' . $var_4d7e9c21_source_file_str); // Stop execution when file permissions prevent hashing.
        } // End the readable-file validation check.
    } // End the source-file validation loop.

    $var_4d7e9c21_results_arr = array(); // Create the return array that will use algorithms as top-level keys.
    foreach ($var_4d7e9c21_algorithms_arr as $var_4d7e9c21_algorithm_str) { // Hash all requested files with each selected algorithm.
        $var_4d7e9c21_results_arr[$var_4d7e9c21_algorithm_str] = array(); // Create the per-algorithm checksum map keyed by source-file path.
        foreach ($var_4d7e9c21_source_files_arr as $var_4d7e9c21_source_file_str) { // Process every requested file for the current algorithm.
            $var_4d7e9c21_checksum_uns = hash_file($var_4d7e9c21_algorithm_str, $var_4d7e9c21_source_file_str); // Calculate the checksum using PHP's streaming file-hash implementation.
            if ($var_4d7e9c21_checksum_uns === FALSE) { // Check whether PHP failed to calculate the checksum.
                throw new RuntimeException('Could not hash file with ' . $var_4d7e9c21_algorithm_str . ': ' . $var_4d7e9c21_source_file_str); // Stop execution rather than returning an incomplete checksum set.
            } // End the hash calculation failure check.
            $var_4d7e9c21_results_arr[$var_4d7e9c21_algorithm_str][$var_4d7e9c21_source_file_str] = $var_4d7e9c21_checksum_uns; // Store the checksum as the value beneath its algorithm and source-file keys.
        } // End the per-file hashing loop.
    } // End the per-algorithm hashing loop.

    return $var_4d7e9c21_results_arr; // Return the complete algorithm-to-file-to-checksum array.
} // End the file hashing function.
