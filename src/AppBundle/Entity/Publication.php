<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractEntity;

/**
 * Publication
 *
 * @ORM\Table(name="publication", indexes={
 *  @ORM\Index(columns={"title"}, flags={"fulltext"}),
 *  @ORM\Index(columns={"sortable_title"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PublicationRepository")
 */
class Publication extends AbstractEntity
{
    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    private $title;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    private $sortableTitle;
        
    /**
     * @var Collection|string[]
     * @ORM\Column(type="array")
     */
    private $links;
    
    /**
     * public research notes.
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;
    
    /**
     * private research notes.
     * @var string
     * @ORM\Column(type="text")
     */
    private $notes;
    
    /**
     * @var DateYear
     * @ORM\OneToOne(targetEntity="DateYear")
     */
    private $dateYear;
    
    /**
     * @var Place
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="publications")
     */
    private $location;
    
    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="publications")
     */
    private $category;
    
    /**
     * @var Collection|Genre[]
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="publications")
     * @ORM\JoinTable(name="publications_genres")
     */
    private $genres;
    
    /**
     * @var Collection|Contribution[]
     * @ORM\OneToMany(targetEntity="Contribution", mappedBy="publication", cascade={"persist"}, orphanRemoval=true)
     */
    private $contributions;
    
    public function __construct() {
        parent::__construct();
        $this->links = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->contributions = new ArrayCollection();
    }
    
    public function __toString() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Publication
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set sortableTitle
     *
     * @param string $sortableTitle
     *
     * @return Publication
     */
    public function setSortableTitle($sortableTitle)
    {
        $this->sortableTitle = $sortableTitle;

        return $this;
    }

    /**
     * Get sortableTitle
     *
     * @return string
     */
    public function getSortableTitle()
    {
        return $this->sortableTitle;
    }

    /**
     * Set links
     *
     * @param array $links
     *
     * @return Publication
     */
    public function setLinks($links)
    {
        $this->links = $links;

        return $this;
    }

    /**
     * Get links
     *
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Publication
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Publication
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set dateYear
     *
     * @param DateYear $dateYear
     *
     * @return Publication
     */
    public function setDateYear(DateYear $dateYear = null)
    {
        $this->dateYear = $dateYear;

        return $this;
    }

    /**
     * Get dateYear
     *
     * @return DateYear
     */
    public function getDateYear()
    {
        return $this->dateYear;
    }

    /**
     * Set location
     *
     * @param Place $location
     *
     * @return Publication
     */
    public function setLocation(Place $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return Place
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set category
     *
     * @param Category $category
     *
     * @return Publication
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add genre
     *
     * @param Genre $genre
     *
     * @return Publication
     */
    public function addGenre(Genre $genre)
    {
        $this->genres[] = $genre;

        return $this;
    }

    /**
     * Remove genre
     *
     * @param Genre $genre
     */
    public function removeGenre(Genre $genre)
    {
        $this->genres->removeElement($genre);
    }

    /**
     * Get genres
     *
     * @return Collection
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Add contribution
     *
     * @param Contribution $contribution
     *
     * @return Publication
     */
    public function addContribution(Contribution $contribution)
    {
        $this->contributions[] = $contribution;

        return $this;
    }

    /**
     * Remove contribution
     *
     * @param Contribution $contribution
     */
    public function removeContribution(Contribution $contribution)
    {
        $this->contributions->removeElement($contribution);
    }

    /**
     * Get contributions
     *
     * @return Collection
     */
    public function getContributions()
    {
        return $this->contributions;
    }
}
