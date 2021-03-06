<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Publication;
use Doctrine\ORM\EntityRepository;

/**
 * PublicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PublicationRepository extends EntityRepository {
    

    public function next(Publication $publication) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere('e.sortableTitle > :q');        
        $qb->setParameter('q', $publication->getSortableTitle());
        $qb->andWhere('e INSTANCE OF :i');
        $qb->setParameter('i', $publication->getCategory());
        $qb->addOrderBy('e.sortableTitle', 'ASC');
        $qb->setMaxResults(1);
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function previous(Publication $publication) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere('e.sortableTitle < :q');
        $qb->setParameter('q', $publication->getSortableTitle());
        $qb->andWhere('e INSTANCE OF :i');
        $qb->setParameter('i', $publication->getCategory());
        $qb->addOrderBy('e.sortableTitle', 'DESC');
        $qb->setMaxResults(1);
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function searchQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->addSelect("MATCH (e.title) AGAINST (:q BOOLEAN) AS HIDDEN score");
        $qb->add('where', "MATCH (e.title) AGAINST (:q BOOLEAN) > 0.5");
        $qb->orderBy('score', 'desc');
        $qb->setParameter('q', $q);
        return $qb->getQuery();
    }

}
