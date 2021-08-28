<?php

namespace Mar4hk0\Fakers;

use SplFileObject;

class DestinationData
{
    protected SplFileObject $file;

    public function __construct(string $tableName)
    {
        $this->file = new SplFileObject($this->generatePath($tableName), 'w');
    }

    public function setData(string $data): void
    {
        $this->file->fwrite($data);
    }

    private function generatePath($tableName): ?string
    {
        if (empty($_ENV['path_to_destination_data'])) {
            return null;
        }
        return __DIR__ . $_ENV['path_to_destination_data'] . $this->generateFileName($tableName);
    }

    private function generateFileName(string $tableName): string
    {
        return $tableName . '.sql';
    }
}
