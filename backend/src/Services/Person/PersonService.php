<?php


namespace App\Services\Person;

use App\Components\Helper\CTSerializer;
use App\Entity\Person\Person;
use App\Repository\Person\PersonRepository;
use App\Services\Redis\RedisServiceInterface;
use Exception;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class PersonService implements PersonServiceInterface
{
    public const PERSON_LIST = 'personList';

    /** @var PersonRepository */
    private PersonRepository $repository;

    /** @var RedisServiceInterface */
    private RedisServiceInterface $redisService;

    public function __construct(PersonRepository $repository, RedisServiceInterface $redisService)
    {
        $this->repository = $repository;
        $this->redisService = $redisService;
    }

    /**
     * @return array
     */
    public function loadPersonsFromRedis(): array
    {
        $persons = [];
        if ($this->isPersonListExists()) {
            $personList = $this->redisService->hgetAll(self::PERSON_LIST, true);

            foreach ($personList as $person) {
                $deserializedPerson = $this->createPersonByPersonData($person);

                $persons[] = $deserializedPerson;
            }
        }

        return $persons;
    }

    /**
     * @return bool
     */
    public function isPersonListExists(): bool
    {
        return $this->redisService->exists(self::PERSON_LIST);
    }

    /**
     * @param string|array $data
     * @return Person|null
     */
    public function createPersonByPersonData($data): ?Person
    {
        /** @var Person $person */
        $person = CTSerializer::deserializeJsonToObject(
            is_string($data) ? $data : json_encode($data),
            Person::class,
            [AbstractNormalizer::OBJECT_TO_POPULATE => new Person()]
        );

        return $person;
    }

    /**
     * @return array
     */
    public function loadPersonsFromDb(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Person $person
     * @param string $list
     * @return $this
     */
    public function setPersonToRedisList(Person $person, string $list = self::PERSON_LIST): self
    {
        $this->setPersonsToRedisList([$person], $list);

        return $this;
    }

    /**
     * @param array $persons
     * @param string $list
     * @return $this
     */
    public function setPersonsToRedisList(array $persons, string $list = self::PERSON_LIST): self
    {
        foreach ($persons as $person) {
            $this->redisService->hset(
                $list,
                (string)$person->getId(),
                CTSerializer::serializeObjectToJson($person)
            );
        }

        return $this;
    }

    /**
     * @param Person $person
     * @return $this
     * @throws Exception
     */
    public function setPersonIntoDb(Person $person): self
    {
        $this->repository->addPerson($person);

        return $this;
    }

    /**
     * @return Person|null
     */
    public function getLastPersonFromDb(): ?Person
    {
        return $this->repository->findOneBy([], ['id' => 'DESC']);
    }

    /**
     * @param int $personId
     * @return Person|null
     */
    public function getPersonFromDb(int $personId): ?Person
    {
        return $this->repository->findOneBy(['id' => $personId]);
    }

    /**
     * @param int $personId
     * @return $this
     */
    public function deletePersonFromDb(int $personId): self
    {
        $this->deletePersonsFromDb([$personId]);

        return $this;
    }

    /**
     * @param array $personIds
     * @return $this
     */
    public function deletePersonsFromDb(array $personIds): self
    {
        $this->repository->deletePersons($personIds);

        return $this;
    }

    /**
     * @param int $personId
     * @param string $list
     * @return $this
     */
    public function deletePersonFromRedisList(int $personId, string $list = self::PERSON_LIST): self
    {
        $this->deletePersonsFromRedisList([$personId], $list);

        return $this;
    }

    /**
     * @param array $personIds
     * @param string $list
     * @return $this
     */
    public function deletePersonsFromRedisList(array $personIds, string $list = self::PERSON_LIST): self
    {
        $this->redisService->hdel($list, $personIds);

        return $this;
    }

    /**
     * @param int $personId
     * @param array $data
     * @return $this
     * @throws Exception
     */
    public function updatePersonForDb(int $personId, array $data): self
    {
        $this->repository->updatePerson($personId, $data);

        return $this;
    }

    /**
     * @param Person $person
     * @param string $list
     * @return $this
     */
    public function updatePersonForRedisList(Person $person, string $list = self::PERSON_LIST): self
    {
        $this->redisService->hdel($list, [$person->getId()]);
        $this->setPersonToRedisList($person, $list);

        return $this;
    }
}
