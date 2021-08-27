<?php

namespace Mar4hk0\Fakers;

abstract class ConvertingCSV
{
    abstract public function run(SourceData $sourceData, DestinationData $destinationData);
}
