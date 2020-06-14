<?php


namespace App\Services\Validator;


interface ValidatorServiceInterface
{
    /**
     * @param array $data
     * @return ValidatorServiceInterface
     */
    public function validate(array $data): ValidatorServiceInterface;

    /**
     * @return array
     */
    public function getErrorMessages(): array;
}