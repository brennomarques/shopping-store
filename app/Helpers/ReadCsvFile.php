<?php

namespace App\Helpers;

use SplFileObject;

class ReadCsvFile
{
    /**
     * ReadFileContents the resource specified to read CSV.
     *
     * @param string $filePath
     * @return array
     *
     */
    public static function readFileContents(string $filePath): ?array
    {

        $csvFile = new SplFileObject($filePath, 'r');

        $csvFile->setCsvControl(',');

        $data = [];

        $csvFile->seek(1);

        while (!$csvFile->eof()) {
            $line = $csvFile->fgetcsv();

            if ($line !== false) {
                $data[] = $line;
            }
        }

        $csvFile = null;

        return $data;
    }
}
