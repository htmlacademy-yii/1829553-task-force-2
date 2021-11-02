<?php

namespace app\fixtures\providers;

use Faker\Generator;
use Faker\Provider\Base;
use yii\db\Exception;
use SplFileObject;

class City extends Base
{
    private const FILE_PATH = __DIR__ . '/cities.csv';
    private SplFileObject $file;
    private array $cities = [];

    public function __construct(Generator $generator)
    {
        parent::__construct($generator);

        if (!file_exists(self::FILE_PATH)) {
            throw new Exception('File does not exist');
        }
        $this->file = new SplFileObject(self::FILE_PATH);
        $this->loadCities();
    }

    private function loadCities()
    {
        // This action get first row in csv file, which contains column name.
        $this->file->fgetcsv();

        $values = [];
        while (!$this->file->eof()) {
            $values[] = $this->file->fgetcsv();
        }
        $this->cities = $values;
    }

    private function getCities(): array
    {
        if (empty($this->cities)) {
            throw new Exception('Something wrong, file ' . self::FILE_PATH . 'is wrong!');
        }

        return $this->cities;
    }

    public function city(int $index)
    {
        $cities = $this->getCities();
        if (empty($cities[$index])) {
            throw new Exception('Wrong rows!');
        }
        return $cities[$index];
    }
}
