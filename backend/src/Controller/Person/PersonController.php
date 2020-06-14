<?php

declare(strict_types=1);

namespace App\Controller\Person;

use App\Controller\Api\ApiController;
use App\Services\Person\PersonServiceInterface;
use App\Services\Validator\ValidatorServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends ApiController
{
    /** @var PersonServiceInterface */
    private PersonServiceInterface $personService;

    public function __construct(PersonServiceInterface $personService)
    {
        $this->personService = $personService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        if (!$this->personService->isPersonListExists()) {
            $persons = $this->personService->loadPersonsFromDb();

            $this->personService->setPersonsToRedisList($persons);

        } else {
            $persons = $this->personService->loadPersonsFromRedis();
        }

        return $this->success(
            [
                'persons' => $persons,
                'total' => count($persons)
            ]
        );
    }

    /**
     * @param Request $request
     * @param ValidatorServiceInterface $validator
     * @return JsonResponse
     */
    public function create(Request $request, ValidatorServiceInterface $validator): JsonResponse
    {
        $data = $request->request->all();
        $errors = $validator->validate($data)->getErrorMessages();

        if ($errors !== []) {
            return $this->json($errors, 400);
        }

        $person = $this->personService->createPersonByPersonData($data);

        try {
            $this->personService->setPersonIntoDb($person);

            $insertedPerson = $this->personService->getLastPersonFromDb();

            $this->personService->setPersonToRedisList($insertedPerson);

        } catch (Exception $exception) {
            return $this->error(['message' => 'Es gab ein Problem mit der Schnittstelle']);
        }

        return $this->success(
            $insertedPerson ?? [],
            Response::HTTP_OK
        );
    }

    /**
     * @param Request $request
     * @param ValidatorServiceInterface $validator
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Request $request, ValidatorServiceInterface $validator): JsonResponse
    {
        $data = $request->request->all();
        $personId = (int)$request->attributes->get('id');
        $errors = $validator->validate($data)->getErrorMessages();

        if ($errors !== []) {
            return $this->json($errors, 400);
        }

        $this->personService->updatePersonForDb($personId, $data);

        $updatedPerson = $this->personService->getPersonFromDb($personId);

        $this->personService->updatePersonForRedisList($updatedPerson);

        return $this->success([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $personsIds = explode(',', $request->attributes->get('ids'));

        $this->personService->deletePersonsFromDb($personsIds);
        $this->personService->deletePersonsFromRedisList($personsIds);

        return $this->success([], Response::HTTP_NO_CONTENT);
    }
}
