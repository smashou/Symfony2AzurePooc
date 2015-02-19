<?php
namespace UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sf_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notebook", mappedBy="user")
     **/
    private $notebooks;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Note", mappedBy="user")
     **/
    private $notes;


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add notebooks
     *
     * @param \AppBundle\Entity\Notebook $notebooks
     * @return User
     */
    public function addNotebook(\AppBundle\Entity\Notebook $notebooks)
    {
        $this->notebooks[] = $notebooks;

        return $this;
    }

    /**
     * Remove notebooks
     *
     * @param \AppBundle\Entity\Notebook $notebooks
     */
    public function removeNotebook(\AppBundle\Entity\Notebook $notebooks)
    {
        $this->notebooks->removeElement($notebooks);
    }

    /**
     * Get notebooks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotebooks()
    {
        return $this->notebooks;
    }

    /**
     * Add notes
     *
     * @param \AppBundle\Entity\Note $notes
     * @return User
     */
    public function addNote(\AppBundle\Entity\Note $notes)
    {
        $this->notes[] = $notes;

        return $this;
    }

    /**
     * Remove notes
     *
     * @param \AppBundle\Entity\Note $notes
     */
    public function removeNote(\AppBundle\Entity\Note $notes)
    {
        $this->notes->removeElement($notes);
    }

    /**
     * Get notes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotes()
    {
        return $this->notes;
    }
}
