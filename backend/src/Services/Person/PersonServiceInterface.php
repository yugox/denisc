<?php


namespace App\Services\Person;


use App\Entity\Person\Person;

interface PersonServiceInterface
{
    /**
     * @return bool
     */
    public function isPersonListExists(): bool;

    /**
     * @return array
     */
    public function loadPersonsFromRedis(): array;

    /**
     * @return array
     */
    public function loadPersonsFromDb(): array;

    /**
     * @param array $persons
     * @param string $list
     * @return $this
     */
    public function setPersonsToRedisList(array $persons, string $list = PersonService::PERSON_LIST): self;

    /**
     * @param Person $person
     * @param string $list
     * @return $this
     */
    public function setPersonToRedisList(Person $person, string $list = PersonService::PERSON_LIST): self;

    /**
     * @param Person $person
     * @return $this
     */
    public function setPersonIntoDb(Person $person): self;

    /**
     * @return Person|null
     */
    public function getLastPersonFromDb(): ?Person;

    /**
     * @param int $personId
     * @return Person|null
     */
    public function getPersonFromDb(int $personId): ?Person;

    /**
     * @param array $data
     * @return Person|null
     */
    public function createPersonByPersonData(array $data): ?Person;

    /**
     * @param array $personIds
     * @param string $list
     * @return $this
     */
    public function deletePersonsFromRedisList(array $personIds, string $list = PersonService::PERSON_LIST): self;

    /**
     * @param int $personId
     * @param string $list
     * @return $this
     */
    public function deletePersonFromRedisList(int $personId, string $list = PersonService::PERSON_LIST): self;

    /**
     * @param int $personId
     * @return $this
     */
    public function deletePersonFromDb(int $personId): self;

    /**
     * @param array $personIds
     * @return $this
     */
    public function deletePersonsFromDb(array $personIds): self;

    /**
     * @param int $personId
     * @param array $data
     * @return $this
     */
    public function updatePersonForDb(int $personId, array $data): self;

    /**
     * @param Person $person
     * @param string $list
     * @return $this
     */
    public function updatePersonForRedisList(Person $person, string $list = PersonService::PERSON_LIST): self;
}
