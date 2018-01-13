<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_admin")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;




    public function __construct()
    {
        parent::__construct();
        $this->galerie = new ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Galerie", mappedBy="utilisateur" , cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */

    private $galerie;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Photo", mappedBy="photoUser" , cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */

    private $photo;


    /**
     * Add galerie
     *
     * @param \AppBundle\Entity\Galerie $galerie
     *
     * @return User
     */
    public function addGalerie(\AppBundle\Entity\Galerie $galerie)
    {
        $this->galerie[] = $galerie;

        return $this;
    }

    /**
     * Remove galerie
     *
     * @param \AppBundle\Entity\Galerie $galerie
     */
    public function removeGalerie(\AppBundle\Entity\Galerie $galerie)
    {
        $this->galerie->removeElement($galerie);
    }

    /**
     * Get galerie
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGalerie()
    {
        return $this->galerie;
    }
}
