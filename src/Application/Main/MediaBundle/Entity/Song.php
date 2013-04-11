<?php

namespace Application\Main\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Song
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Application\Main\MediaBundle\Repository\SongRepository")
 */
class Song
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

//    /////////////////////////////////////
//    /**
//     * @Assert\File(maxSize="6000000")
//     */
//    public $file;
//
//
//    public function getAbsoluteImage()
//    {
//        return null === $this->path
//            ? null
//            : $this->getUploadRootDir().'/'.$this->path;
//    }
//
//    public function getWebImage()
//    {
//        return null === $this->path
//            ? null
//            : $this->getUploadDir().'/'.$this->path;
//    }
//
//    protected function getUploadRootDir()
//    {
//        // the absolute directory path where uploaded
//        // documents should be saved
//        return __DIR__.'/../../../../web/'.$this->getUploadDir();
//    }
//
//    protected function getUploadDir()
//    {
//        // get rid of the __DIR__ so it doesn't screw up
//        // when displaying uploaded doc/path in the view.
//        return 'uploads/media/tracks';
//    }
//
//
//    /**
//     * @ORM\PrePersist()
//     * @ORM\PreUpdate()
//     */
//    public function preUpload()
//    {
//        if (null !== $this->file) {
//            // do whatever you want to generate a unique name
//            $filename = sha1(uniqid(mt_rand(), true));
//            If($this->file->guessExtension() == 'mpga') {
//                $this->path = $filename.'.mp3';
//            }
//            //$this->path = $filename.'.'.$this->file->guessExtension();
//        }
//    }
//
//    /**
//     * @ORM\PostPersist()
//     * @ORM\PostUpdate()
//     */
//    public function upload()
//    {
//        if (null === $this->file) {
//            return;
//        }
//        // if there is an error when moving the file, an exception will
//        // be automatically thrown by move(). This will properly prevent
//        // the entity from being persisted to the database on error
//        $this->file->move($this->getUploadRootDir(), $this->path);
//        unset($this->file);
//    }
//    /**
//     * @ORM\PostRemove()
//     */
//    public function removeUpload()
//    {
//        if ($file = $this->getAbsoluteImage()) {
//            unlink($file);
//        }
//    }
//
//
//    /////////////////////////////////////

    //
    /**
     * @ORM\OneToOne(targetEntity="Application\Main\CartBundle\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     **/
    private $product;
    //

    public function __toString(){
        return $this->title;
    }

    public function __construct(){
        $this->createdAt = $this->updatedAt = new \DateTime();
        $this->isActive = false;
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
     * Set title
     *
     * @param string $title
     * @return Song
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Song
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Song
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Song
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set product
     *
     * @param \Application\Main\CartBundle\Entity\Product $product
     * @return Song
     */
    public function setProduct(\Application\Main\CartBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return \Application\Main\CartBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}