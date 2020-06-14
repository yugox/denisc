<?php

declare(strict_types=1);

namespace App\Validator\Person;

use Symfony\Component\Validator\Constraints as Assert;


class PersonConstraint
{
    /**
     * @return Assert\Collection
     */
    public static function getContraintForPersonCreate(): Assert\Collection
    {
        return new Assert\Collection(
            [
                'firstname' => new Assert\Required(
                    [
                        new Assert\NotBlank(
                            [
                                'message' => 'Bitte geben Sie ihren Vornamen an'
                            ]
                        ),
                        new Assert\Type('string'),
                        new Assert\Length(['max' => 50]),
                    ]
                ),
                'lastname' => new Assert\Required(
                    [
                        new Assert\NotBlank(
                            [
                                'message' => 'Bitte geben Sie ihren Nachnamen an'
                            ]
                        ),
                        new Assert\Type('string'),
                        new Assert\Length(['max' => 50]),
                    ]
                ),
                'age' => new Assert\Required(
                    [
                        new Assert\NotBlank(
                            [
                                'message' => 'Bitte geben Sie ihr Alter an'
                            ]
                        ),
                        new Assert\Type('integer'),
                        new Assert\Range(
                            [
                                'min' => 1,
                                'max' => 100,
                                'minMessage' => 'Dein Alter muss mindestens {{ limit }}Jahr betragen',
                                'maxMessage' => 'Dein Alter darf höchstens {{ limit }}Jahre betragen',
                            ]
                        ),
                    ]
                )
            ]
        );
    }
}