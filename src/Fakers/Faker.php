<?php

namespace Mar4hk0\Fakers;

class Faker
{
    private ConvertingCSV $converter;

    public function __construct()
    {
        Config::create();
        $this->converter = ConvertingFactory::create();
    }

    public function run()
    {
        $list = SourceDataCSV::getListSourceData();
        foreach ($list as $sourceData) {
            $destinationData = new DestinationData($sourceData->getTableName());
            $this->converter->run($sourceData, $destinationData);
        }
    }


}
