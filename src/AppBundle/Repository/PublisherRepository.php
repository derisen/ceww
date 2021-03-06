<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Person;
use Doctrine\ORM\EntityRepository;

/**
 * PublisherRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PublisherRepository extends EntityRepository {

    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("e.name LIKE :q");
        $qb->orderBy('e.name');
        $qb->setParameter('q', "%{$q}%");
        return $qb->getQuery()->execute();
    }

    public function searchQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->addSelect("MATCH (e.name) AGAINST (:q BOOLEAN) as HIDDEN score");
        $qb->add('where', "MATCH (e.name) AGAINST (:q BOOLEAN) > 0.5");
        $qb->orderBy('score', 'desc');
        $qb->setParameter("q", $q);
        return $qb->getQuery();
    }

    public function byPerson(Person $person) {
        $qb = $this->createQueryBuilder('pb');
        $qb->distinct();
        $qb->join('pb.publications', 't'); // t for title.
        $qb->join('t.contributions', 'c');
        $qb->andWhere('c.person = :person');
        $qb->setParameter('person', $person);
        $qb->orderBy('pb.name');
        return $qb->getQuery()->execute();
    }

}
