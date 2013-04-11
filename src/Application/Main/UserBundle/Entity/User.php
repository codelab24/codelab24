<?php
/**
 * Touchwire Software 2010-2020
 * User: developer
 * Date: 4/10/13
 * Time: 11:23 AM
 * File: User.php
 */

namespace Application\Main\UserBundle\Entity;
 
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
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
         * @var string
         *
         * @ORM\Column(name="firstname", type="string", length=255)
         */
        private $firstname;

    /**
             * @var string
             *
             * @ORM\Column(name="surname", type="string", length=255)
             */
            private $surname;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
         * @var string
         *
         * @ORM\Column(name="facebookId", type="string", length=255, nullable=true)
         */
        protected $facebookId;

    public function serialize()
        {
            return serialize(array($this->facebookId, parent::serialize()));
        }

        public function unserialize($data)
        {
            list($this->facebookId, $parentData) = unserialize($data);
            parent::unserialize($parentData);
        }

        /**
         * Get the full name of the user (first + last name)
         * @return string
         */
        public function getFullName()
        {
            return $this->getFirstname() . ' ' . $this->getLastname();
        }

        /**
         * @param string $facebookId
         * @return void
         */
        public function setFacebookId($facebookId)
        {
            $this->facebookId = $facebookId;
        }

        /**
         * @return string
         */
        public function getFacebookId()
        {
            return $this->facebookId;
        }

        /**
         * @param Array
         */
        public function setFBData($fbdata)
        {
            if (isset($fbdata['id'])) {
                $this->setFacebookId($fbdata['id']);
                $this->addRole('ROLE_FACEBOOK');
            }
            if (isset($fbdata['first_name'])) {
                $this->setFirstname($fbdata['first_name']);
            }
            if (isset($fbdata['last_name'])) {
                $this->setSurname($fbdata['last_name']);
            }
            if (isset($fbdata['email'])) {
                $this->setEmail($fbdata['email']);
            }
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
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }
}
