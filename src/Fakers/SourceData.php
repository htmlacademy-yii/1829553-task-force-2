<?php

namespace Mar4hk0\Fakers;

use SplFileObject;

abstract class SourceData
{
    protected string $tableName;
    protected SplFileObject $file;

    public function __construct(string $tableName, SplFileObject $file)
    {
        $this->tableName = $tableName;
        $this->file = $file;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getFile(): SplFileObject
    {
        return $this->file;
    }

    abstract public static function getListSourceData();
}
