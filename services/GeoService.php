<?php

namespace app\services;

use app\services\Geo\Geo;
use app\services\Geo\GeoPoint;
use app\services\Geo\House;
use app\services\Geo\Street;
use app\services\Geo\ValidateHouse;
use app\services\Geo\ValidateStreet;
use yii\helpers\ArrayHelper;

class GeoService extends Geo
{

    private const KIND_STREET = 'street';
    private const KIND_HOUSE = 'house';
    private const KIND = [self::KIND_STREET, self::KIND_HOUSE];
    private const COUNTRY_CODE = 'RU';

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getListAddress(): array
    {
        $buffer = ArrayHelper::getValue($this->data, 'response.GeoObjectCollection.featureMember');
        $filteredBuffer = $this->filter($buffer);
        $list = $this->createListGeoObjects($filteredBuffer);
        $result = [];
        foreach ($list as $item) {
            /* @var $item GeoPoint */
            $result[] = [
                'full_address' => $item->getFullAddress(),
                'long' => $item->getLong(),
                'lat' => $item->getLat(),
            ];
        }
        return $result;
    }

    private function filter(array $data): array
    {
        $result = [];
        foreach ($data as $item) {
            $kind = $this->getKind($item);
            $countryCode = $this->getCountryCode($item);
            if (in_array($kind, self::KIND) && $countryCode == self::COUNTRY_CODE) {
                $result[] = $item;
            }
        }

        return $result;
    }

    private function createListGeoObjects(array $data): array
    {
        $result = [];
        foreach ($data as $item) {
            $kind = $this->getKind($item);
            $geo = null;
            $geoCoordinates = $this->getGeoCoordinates($item);
            if (empty($geoCoordinates)) {
                continue;
            }
            $components = $this->getAddressComponents($item);
            $locality = $this->getLocality($components);
            $street = $this->getStreet($components);
            if ($kind == self::KIND_HOUSE) {
                $house = $this->getHouse($components);
                $validate = new ValidateHouse($locality, $street, $house);
                if (!$validate->check()) {
                    continue;
                }
                $geo = new House($locality, $street, $house, $geoCoordinates);
            }
            if ($kind == self::KIND_STREET) {
                $validate = new ValidateStreet($locality, $street);
                if (!$validate->check()) {
                    continue;
                }
                $geo = new Street($locality, $street, $geoCoordinates);
            }

            if (!empty($geo)) {
                $result[] = $geo;
            }
        }
        return $result;

    }

    private function getKind(array $item): string
    {
        return ArrayHelper::getValue($item, 'GeoObject.metaDataProperty.GeocoderMetaData.kind');
    }

    private function getCountryCode(array $item): string
    {
        return ArrayHelper::getValue($item, 'GeoObject.metaDataProperty.GeocoderMetaData.AddressDetails.Country.CountryNameCode');
    }

    private function getAddressComponents(array $item): array
    {
        return ArrayHelper::getValue($item, 'GeoObject.metaDataProperty.GeocoderMetaData.Address.Components');
    }

    private function getLocality(array $data): ?string
    {
        foreach ($data as $item) {
            if (!empty($item['kind']) && $item['kind'] == 'locality') {
                return $item['name'];
            }
        }
        return null;
    }

    private function getStreet(array $data): ?string
    {
        foreach ($data as $item) {
            if (!empty($item['kind']) && $item['kind'] == 'street') {
                return $item['name'];
            }
        }
        return null;
    }

    private function getHouse(array $data): ?string
    {
        foreach ($data as $item) {
            if (!empty($item['kind']) && $item['kind'] == 'house') {
                return $item['name'];
            }
        }
        return null;
    }

    private function getGeoCoordinates(array $item): array
    {
        $result = [];
        $point = ArrayHelper::getValue($item, 'GeoObject.Point.pos');
        if (empty($point)) {
            return $result;
        }

        [$long, $lat] = explode(' ', $point);
        return [
            'long' => $long,
            'lat' => $lat,
        ];
    }


//    private function getListGeo(array $data): array
//    {
//        $result = [];
//        foreach ($data as $item) {
//            $point = ArrayHelper::getValue($item, 'GeoObject.Point.pos');
//            if (empty($point)) {
//                continue;
//            }
//            $kind = ArrayHelper::getValue($item, 'GeoObject.metaDataProperty.GeocoderMetaData.kind');
//
//            [$long, $lat] = explode(' ', $point);
//            $result[] = [
//                'address' => ArrayHelper::getValue(
//                    $item,
//                    'GeoObject.metaDataProperty.GeocoderMetaData.AddressDetails.Country.AddressLine'
//                ),
//                'lat' => $lat,
//                'long' => $long,
//            ];
////            latitude - широта 55.756893
////            longitude - долгота 37.61116
//        }
//
//        return $result;
//    }



}
