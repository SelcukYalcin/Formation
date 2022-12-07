<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function save(Session $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Session $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    // <---------- AFFICHER LES SESSIONS PASSEES ---------->
    public function displayPastSessions() 
    {
        $now = new \DateTime();
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateFin < :val')
            ->setParameter('val', $now)
            ->orderBy('s.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }
    // <---------- AFFICHER LES SESSIONS EN COURS ---------->
    public function displayCurrentSessions() 
    {
        $now = new \DateTime();
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateDebut < :val')
            ->andWhere('s.dateFin > :val')
            ->setParameter('val', $now)
            ->orderBy('s.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }
    // <---------- AFFICHER LES SESSIONS A VENIR ---------->
    public function displayUpcomingSessions() 
    {
        $now = new \DateTime();
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateDebut > :val')
            ->setParameter('val', $now)
            ->orderBy('s.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findNonInscrits($session_id)
    {
        $em = $this->getEntityManager();
        $sub =$em->createQueryBuilder();

        $qb = $sub;
        $qb->select('s')
            ->from('App\Entity\Stagiaire','s')
            ->leftJoin('s.sessions', 'se')
            ->where('se.id = :id');

        $sub = $em->createQueryBuilder();
        $sub->select('st')
            ->from('App\Entity\Stagiaire','st')
            ->where($sub->expr()->notIn('st.id', $qb->getDQL()))
            ->setParameter('id', $session_id)
            ->orderBy('st.nom');

        $query = $sub->getQuery();
        return $query->getResult();
    }

//    /**
//     * @return Session[] Returns an array of Session objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Session
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
