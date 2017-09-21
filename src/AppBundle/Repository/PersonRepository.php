<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Role;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;

/**
 * PersonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PersonRepository extends EntityRepository {

    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("e.sortableName LIKE :q");
        $qb->orderBy('e.sortableName');
        $qb->setParameter('q', "{$q}%");
        return $qb->getQuery()->execute();
    }
    
    public function searchQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->addSelect("MATCH_AGAINST (e.fullName, :q 'IN BOOLEAN MODE') as HIDDEN score");
        $qb->add('where', "MATCH_AGAINST (e.fullName, :q 'IN BOOLEAN MODE') > 0.5");
        $qb->orderBy('score', 'desc');
        $qb->setParameter('q', $q);
        return $qb->getQuery();
    }
    
    /**
     * @param Role $role
     * @return Query
     */
    public function byRoleQuery(Role $role) {
        $qb = $this->createQueryBuilder('p');
        $qb->join('p.contributions', 'c', Join::WITH, 'c.role = :role');
        $qb->orderBy('p.sortableName');
        $qb->setParameter('role', $role);
        return $qb->getQuery();
    }

}
