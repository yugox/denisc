<?php

namespace App\Tests\Services\Person;

use App\Services\Person\PersonServiceInterface;
use App\Tests\Traits\Person as PersonTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PersonServiceTest extends WebTestCase
{
    use PersonTrait;

    /** @var PersonServiceInterface */
    private PersonServiceInterface $personService;

    protected function setUp()
    {
        self::bootKernel();
        /** @var PersonServiceInterface $this->personService personService */
        $this->personService = static::$container->get(PersonServiceInterface::class);
    }

    public function testCreatePersonByPersonData()
    {
        $this->assertEquals($this->getDefaultPersonObject(),
                            $this->personService->createPersonByPersonData($this->getDefaultPersonData()));
    }
}
