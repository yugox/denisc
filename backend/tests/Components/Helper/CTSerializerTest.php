<?php

namespace App\Tests\Components\Helper;

use App\Components\Helper\CTSerializer;
use App\Entity\Person\Person;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class CTSerializerTest extends TestCase
{
    public function testDeserializeJsonToObjectWithContext(): void
    {
        $data = [
            'firstname' => 'Max',
            'lastname' => 'Mustermann',
            'age' => 30
        ];

        $person = new Person();
        $this->assertEquals(null, $person->getFirstname());
        $this->assertEquals(null, $person->getLastname());
        $this->assertEquals(null, $person->getAge());

        CTSerializer::deserializeJsonToObject(
            json_encode($data),
            Person::class,
            [AbstractNormalizer::OBJECT_TO_POPULATE => $person]
        );

        $this->assertEquals('Max', $person->getFirstname());
        $this->assertEquals('Mustermann', $person->getLastname());
        $this->assertEquals(30, $person->getAge());
    }

    public function testSerializeObjectToJson(): void
    {
        $person = new Person();
        $person->setId(1)
            ->setFirstname('Max')
            ->setLastname('Mustermann')
            ->setAge(32);

        $expected = '{"id":1,"firstname":"Max","lastname":"Mustermann","age":32}';

        $this->assertEquals($expected, CTSerializer::serializeObjectToJson($person));
    }
}
