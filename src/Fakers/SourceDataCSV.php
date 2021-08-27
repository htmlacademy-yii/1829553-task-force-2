<?php

namespace Mar4hk0\Fakers;

use Mar4hk0\Exceptions\ExceptionSourceDataCSV;
use SplFileObject;

class SourceDataCSV extends SourceData
{
    /**
     * @throws ExceptionSourceDataCSV
     */
    public static function getListSourceData(): ?array
    {
        if (!is_array($_ENV['files_name']) || empty($_ENV['files_name'])) {
            return null;
        }
        $files = [];
        foreach ($_ENV['files_name'] as $tableName => $fileName) {
            $file = __DIR__ . $_ENV['path_to_source_data'] . $fileName;
            if (empty(file_exists($file))) {
                throw new ExceptionSourceDataCSV($file . ' does not exit.');
            }
            $files[] = new SourceDataCSV($tableName, new SplFileObject($file));
        }
        return $files;
    }

}
