<?php

declare(strict_types=1);

namespace App\Components\Helper;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CTSerializer
{
    private const JSON = 'json';

    /** @var Serializer|null */
    private static ?Serializer $instance = null;

    private function __construct(){}

    /**
     * @return Serializer
     */
    private static function getSerializer(): Serializer
    {
        if(self::$instance === null) {
            $encoders = [new XmlEncoder(), new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];

            self::$instance = new Serializer($normalizers, $encoders);
        }

        return self::$instance;
    }

    /**
     * @param $data
     * @return string
     */
    public static function serializeObjectToJson($data): string
    {
        return self::getSerializer()->serialize($data, self::JSON);
    }

    /**
     * @param $data
     * @param string $type
     * @param array $context
     *
     * @return array|object
     */
    public static function deserializeJsonToObject($data, string $type, array $context = [])
    {
        return self::getSerializer()->deserialize($data, $type, self::JSON, $context);
    }
}
