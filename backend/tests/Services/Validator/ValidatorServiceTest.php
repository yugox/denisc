<?php

namespace App\Tests\Services\Validator;

use App\Services\Validator\ValidatorServiceInterface;
use App\Tests\Traits\Person;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ValidatorServiceTest extends WebTestCase
{
    use Person;

    /** @var ValidatorServiceInterface $validatorService */
    private ValidatorServiceInterface $validatorService;

    public function setUp()
    {
        self::bootKernel();
        /** @var ValidatorServiceInterface $this->validatorService */
        $this->validatorService = self::$container->get(ValidatorServiceInterface::class);
    }

    public function testValidate()
    {
        $errors = $this->validatorService->validate($this->getDefaultPersonDataWithAgeError())->getErrorMessages();

        $this->assertCount(1, $errors);
        $this->assertArrayHasKey('[age]', $errors);
        $this->assertEquals($errors['[age]'][0], 'This value should be of type integer.');
    }
}
