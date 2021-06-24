<?php

namespace App\Repository;

use App\Entity\Vacature;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vacature|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vacature|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vacature[]    findAll()
 * @method Vacature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VacatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vacature::class);
    }

    public function ophalenVacature($vac_id){

        $data = $this->find($vac_id);
        return($data);
    }

    public function ophalenVacatures(){

        $data = $this->findAll();
        return($data);
    }

    public function opslaanVacature($vaca){

        $vacature = new Vacature();

        $em = $this->getEntityManager();

        $userRepo = $em->getRepository(User::class);

        $userWG = $userRepo->find($vaca["user_wg_id"]);

        $vacature->setUserWG($userWG);
        $vacature->setTitel($vaca["titel"]);
        $vacature->setOmschrijving($vaca["omschrijving"]);
        $vacature->setNiveau($vaca["niveau"]);
        $vacature->setDatum($vaca["datum"]);

        $em->persist($vacature);
        $em->flush();

        return($vacature);
    }

    public function sorteerVacatures(){

        $data = $this->findBy([], array("datum" => 'DESC'));
        return($data);
    }

    // /**
    //  * @return Vacature[] Returns an array of Vacature objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vacature
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
