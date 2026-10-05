<?php

namespace App\Services;

class ExportService {
    /**
     * Sanitize string value against CSV Spreadsheet Formula Injection
     * Prefixes unsafe leading characters (=, +, -, @, \t, \r) with a single quote.
     */
    public static function sanitizeCsvValue(?string $val): string {
        if ($val === null) return '';
        $val = trim($val);
        if ($val === '') return '';

        $firstChar = $val[0];
        if (in_array($firstChar, ['=', '+', '-', '@', "\t", "\r"])) {
            return "'" . $val;
        }

        return $val;
    }

    /**
     * Stream array of rows as CSV download with formula protection
     */
    public static function streamCsv(string $filename, array $headers, array $data): void {
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');

        // Write UTF-8 BOM for Excel compatibility
        fputs($out, "\xEF\xBB\xBF");

        // Write headers
        fputcsv($out, $headers);

        // Write sanitized rows
        foreach ($data as $row) {
            $sanitizedRow = array_map([self::class, 'sanitizeCsvValue'], array_values($row));
            fputcsv($out, $sanitizedRow);
        }

        fclose($out);
        exit();
    }
}
