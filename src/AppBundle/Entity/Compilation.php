<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Collection
 *
 * @ORM\Table(name="collection")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompilationRepository")
 */
class Compilation extends Publication
{
    public function getCategory() {
        return self::COMPILATION;
    }
}
