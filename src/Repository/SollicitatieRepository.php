<?php

namespace App\Repository;

use App\Entity\Sollicitatie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sollicitatie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sollicitatie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sollicitatie[]    findAll()
 * @method Sollicitatie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SollicitatieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sollicitatie::class);
    }

    public function ophalenSollicitatiePerGebruiker($user){

        $sollicitaties = $this->findBy(array("userWN" => $user), array("datum" => "ASC"));
        return($sollicitaties);
    }

    public function opslaanSollicitatie($soll, $userWN, $vacature){

        if(isset($soll["id"])){
            $sollicitatie = $this->find($soll["id"]);
        }else{
            $sollicitatie = new Sollicitatie();
        }
        
        $em = $this->getEntityManager();

        $sollicitatie->setUserWN($userWN);
        $sollicitatie->setVacature($vacature);

        $sollicitatie->setCv($soll["cv"]);
        $sollicitatie->setMotivatie($soll["motivatie"]);
        $sollicitatie->setUitnodiging($soll["uitnodiging"]);
        $sollicitatie->setDatum($soll["datum"]);

        $em->persist($sollicitatie);
        $em->flush();

        return($sollicitatie);
    }

    public function verwijderSollicitatie($soll_id){

        $sollicitatie = $this->find($soll_id);

        $em = $this->getEntityManager();
        $em->remove($sollicitatie);
        $em->flush();

        return(true);
    }

    public function verstuurUitnodiging($soll_id) {

        $sol = $this->find($soll_id);
        $sol->setUitnodiging(true);
        
        $this->_em->persist($sol);
        $this->_em->flush();

        return($sol);
    }

    public function veranderMotivatie($soll_id, $new_mot){

        $sol = $this->find($soll_id);
        $sol->setMotivatie($new_mot);
        
        $this->_em->persist($sol);
        $this->_em->flush();

        return($sol);
    }

    // /**
    //  * @return Sollicitatie[] Returns an array of Sollicitatie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sollicitatie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
