<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return mixed
     */
    public function getDateUpload()
    {
        return $this->dateUpload;
    }

    /**
     * @param mixed $dateUpload
     */
    public function setDateUpload($dateUpload)
    {
        $this->dateUpload = $dateUpload;
    }

    /**
     * @return string
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * @param string $fileSize
     *
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;
    }





    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="photo")
     * @ORM\JoinColumn(nullable=false)
     */

    private $photoUser;

    /**
     * @return mixed
     */
    public function getPhotoUser()
    {
        return $this->photoUser;
    }

    /**
     * @param mixed $photoUser
     */
    public function setPhotoUser($photoUser)
    {
        $this->photoUser = $photoUser;
    }

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Galerie",cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid()
     * @Assert\Type("AppBundle\Entity\Galerie")
     */

    private $galerie;


    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var date
     *
     * @ORM\Column(name="dateUpload", type="date", nullable=true)
     */
    private $dateUpload;

    /**
     * @var string
     *
     * @ORM\Column(name="fileSize", type="string", length=255, nullable=true)
     */
    private $fileSize;




    /**
     * Get id
     *
     * @return int
     */


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;






    /**
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/png", "image/jpeg"},
     *     mimeTypesMessage = "Merci d'uploader une image valide"
     * )
     */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }


    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return '../ProjetFramework/web/uploads/photo';
    }



    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Photo
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Photo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set galerie
     *
     * @param \AppBundle\Entity\Galerie $galerie
     *
     * @return Photo
     */
    public function setGalerie(\AppBundle\Entity\Galerie $galerie = null)
    {
        $this->galerie = $galerie;

        return $this;
    }

    /**
     * Get galerie
     *
     * @return \AppBundle\Entity\Galerie
     */
    public function getGalerie()
    {
        return $this->galerie;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
}
