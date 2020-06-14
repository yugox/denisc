<?php


namespace App\Services\Redis;


interface RedisServiceInterface
{
    // 8 Stunde
    public const DEFAULT_LIFETIME = 60 * 60 * 8;

    /**
     * @param string $key
     * @param array $fields
     * @return $this
     */
    public function hdel(string $key, array $fields): self;

    /**
     * @param string $key
     * @param string $field
     * @param $value
     * @param float|int $expire
     */
    public function hset(string $key, string $field, $value, $expire = self::DEFAULT_LIFETIME): void;

    /**
     * @param string $key
     * @param string $field
     * @param bool $assoc
     * @return string
     */
    public function hget(string $key, string $field, bool $assoc = false): string;

    /**
     * @param string $key
     * @param bool $assoc
     * @return mixed
     */
    public function hgetAll(string $key, bool $assoc = false);

    /**
     * @param string $key
     * @param $value
     * @param float|int $expire
     */
    public function set(string $key, $value, $expire = self::DEFAULT_LIFETIME): void;

    /**
     * @param string $key
     * @param bool $assoc
     * @return string
     */
    public function get(string $key, bool $assoc = false): string;

    /**
     * @param string $key
     * @param $value
     */
    public function pushToList(string $key, $value): void;

    /**
     * @param string $key
     * @return array
     */
    public function getCompleteList(string $key): array;

    /**
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool;
}
