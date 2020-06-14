<?php


namespace App\Services\Validator;


use App\Validator\Person\PersonConstraint;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorService implements ValidatorServiceInterface
{
    /** @var ValidatorInterface */
    private ValidatorInterface $validator;

    /** @var ConstraintViolationListInterface */
    private ConstraintViolationListInterface $errors;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @return $this|ValidatorServiceInterface
     */
    public function validate(array $data): ValidatorServiceInterface
    {
        $this->errors = $this->validator->validate($data, PersonConstraint::getContraintForPersonCreate());

        return $this;
    }

    /**
     * @return array
     */
    public function getErrorMessages(): array
    {
        $validationErrors = [];
        if (count($this->errors) > 0) {
            foreach ($this->errors as $error) {
                $validationErrors[$error->getPropertyPath()][] = $error->getMessage();
            }
        }

        return $validationErrors;
    }
}