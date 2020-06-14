<?php


namespace App\Services\Redis;


use App\Components\Helper\CTSerializer;
use Predis\Client;

class RedisService implements RedisServiceInterface
{
    /** @var Client */
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $key
     * @param array $fields
     * @return $this
     */
    public function hdel(string $key, array $fields): self
    {
        $this->client->hdel($key, $fields);

        return $this;
    }

    /**
     * @param string $key
     * @param string $field
     * @param $value
     * @param float|int $expire
     */
    public function hset(string $key, string $field, $value, $expire = self::DEFAULT_LIFETIME): void
    {
        $this->client->hset($key, $field, CTSerializer::serializeObjectToJson($value));
        $this->client->expire($key, $expire);
    }

    /**
     * @param string $key
     * @param string $field
     * @param bool $assoc
     * @return string
     */
    public function hget(string $key, string $field, bool $assoc = false): string
    {
        return json_decode($this->client->hget($key, $field), $assoc);
    }

    /**
     * @param string $key
     * @param bool $assoc
     * @return object|array
     */
    public function hgetAll(string $key, bool $assoc = false)
    {
        $data = $this->client->hgetAll($key) ?? [];

        array_walk(
            $data,
            static function (&$item) use ($assoc): void {
                $item = json_decode($item, $assoc);
            }
        );

        return $data;
    }

    /**
     * @param string $key
     * @param $value
     * @param float|int $expire
     */
    public function set(string $key, $value, $expire = self::DEFAULT_LIFETIME): void
    {
        $this->client->set($key, json_encode($value), null, $expire);
    }

    /**
     * @param string $key
     * @param bool $assoc
     * @return string
     */
    public function get(string $key, bool $assoc = false): string
    {
        return json_decode($this->client->get($key), $assoc);
    }

    /**
     * @param string $key
     * @param string|array $value
     */
    public function pushToList(string $key, $value): void
    {
        $value = is_string($value) ? [$value] : $value;

        $this->client->rpush($key, $value);
    }

    /**
     * @param string $key
     * @return array
     */
    public function getCompleteList(string $key): array
    {
        return $this->client->lrange($key, 0, -1);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool
    {
        return (bool)$this->client->exists($key);
    }
}
