<?php

namespace Mar4hk0\Fakers;

use Mar4hk0\Exceptions\ExceptionConveringCSVMySQL;
use SplFileObject;

class ConveringCSVMySQL extends ConvertingCSV
{
    public function run(SourceData $sourceData, DestinationData $destinationData)
    {
        $file = $sourceData->getFile();
        $file->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
        $tableName = $sourceData->getTableName();

        $existColumns = $this->getExistColumns($file);
        $requireColumns = $this->getRequireColumns($tableName);

        $destinationData->setData($this->generateInsertRow($tableName, array_keys($requireColumns)));
        try {
            $separator = ",\n";
            $buf = null;
            foreach ($this->getNextLine($file) as $line) {
                if (!is_null($buf)) {
                    $destinationData->setData($buf);
                }
                if (empty($line)) {
                    $separator = ";\n";
                    continue;
                }
                if (!is_null($buf)) {
                    $destinationData->setData($separator);
                }
                $data = array_combine($existColumns, $line);
                $row = new Row($data, $requireColumns);
                $row->generateItems();
                $buf = $row->generateString();
            }
            $destinationData->setData($separator);

        }
        catch (\Exception $exception) {
            throw new ExceptionConveringCSVMySQL($exception->getMessage(), $exception->getCode(), $exception);
        }

    }

    private function generateInsertRow(string $tableName, array $columns): string
    {
        $columns = implode(', ', $columns);
        return "INSERT $tableName ($columns)\nVALUES\n";
    }

    private function getExistColumns(\SplFileObject $file): ?array
    {
        $file->rewind();
        $columns = $file->fgetcsv();
        $result = [];
        foreach ($columns as $item) {
            $result[] = trim($item);
        }
        return $result;
    }

    private function getRequireColumns(string $tableName): ?array
    {
        if (empty($_ENV['struct_tables'][$tableName])) {
            return null;
        }

        return $_ENV['struct_tables'][$tableName];
    }

    private function getNextLine(\SplFileObject $file):?iterable {
        while (!$file->eof()) {
            yield $file->fgetcsv();
        }
        return null;
    }



}
