<?php

namespace app\controllers;

use app\models\User;
use app\services\GeoService;
use Yii;
use Exception;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use yii\web\BadRequestHttpException;

class AjaxController extends SecuredController
{
    public function actionGetGeo($address)
    {

        try {
            /* @var $user User */
            $user = Yii::$app->params['user'];
            $cityName = $user->city->name;

            $address = 'город ' . $cityName . ', ' . $address;
            $client = new Client([
                'base_uri' => 'https://geocode-maps.yandex.ru/1.x/',
            ]);

            $apiKey = Yii::$app->params['apiGeoKey'];
            $request = new Request('GET', '');
            $response = $client->send(
                $request,
                [
                    'query' => [
                        'apikey' => $apiKey,
                        'geocode' => $address,
                        'format' => 'json',
                    ]
                ]
            );

            if ($response->getStatusCode() !== 200) {
                throw new BadResponseException('Response error: ' . $response->getReasonPhrase(), $request, $response);
            }

            $content = $response->getBody()->getContents();
            $data = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ServerException('Invalid json format', $request, $response);
            }

            $geoService = new GeoService($data);
            return $this->asJson($geoService->getListAddress());
        }
        catch (Exception $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }
    }


}
