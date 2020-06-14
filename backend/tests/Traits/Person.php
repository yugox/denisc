<?php


namespace App\Tests\Traits;


use App\Entity\Person\Person as PersonEntity;

trait Person
{
    /**
     * @return PersonEntity
     */
    protected function getDefaultPersonObject(): PersonEntity
    {
        $person = new PersonEntity();
        $person->setFirstname('Max')
            ->setLastname('Mustermann')
            ->setAge(23);

        return $person;
    }

    /**
     * @return array
     */
    protected function getDefaultPersonData(): array
    {
        return [
            'firstname' => 'Max',
            'lastname' => 'Mustermann',
            'age' => 23,
        ];
    }

    /**
     * @return array
     */
    protected function getDefaultPersonDataWithAgeError(): array
    {
        return [
            'firstname' => 'Max',
            'lastname' => 'Mustermann',
            'age' => '23',
        ];
    }
}
