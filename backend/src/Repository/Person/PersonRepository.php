<?php

namespace App\Repository\Person;

use App\Entity\Person\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    /**
     * @param Person $person
     * @return $this
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addPerson(Person $person): self
    {
        $this->getEntityManager()->persist($person);
        $this->getEntityManager()->flush();

        return $this;
    }

    /**
     * @param array $personIds
     * @return $this
     */
    public function deletePersons(array $personIds): self
    {
        $this->createQueryBuilder('p')
            ->andWhere('p.id IN(:personIds)')
            ->setParameter('personIds', $personIds)
            ->delete()
            ->getQuery()
            ->execute();

        return $this;
    }

    /**
     * @param int $id
     * @param array $personData
     * @return $this
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updatePerson(int $id, array $personData): self
    {
        /** @var Person $person */
        $person = $this->getEntityManager()->getRepository(Person::class)->find($id);
        $person->setFirstname($personData['firstname'])
            ->setLastname($personData['lastname'])
            ->setAge($personData['age']);

        $this->getEntityManager()->flush();

        return $this;
    }
}
