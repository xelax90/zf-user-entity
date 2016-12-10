<?php
namespace XelaxUserEntity\Entity;

use BjyAuthorize\Provider\Role\ProviderInterface as RoleProvider;
use ZfcUser\Entity\User as ZfcUserEntity;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Zend\Json\Json;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;
use ZF2LanguageRoute\Entity\LocaleUserInterface;
use ZF2LanguageRoute\Entity\LocaleUserTrait;

/**
 * A User.
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks
 */
class User extends ZfcUserEntity implements JsonSerializable, RoleProvider, LocaleUserInterface
{
	use LocaleUserTrait;
	
	const STATE_ACTIVE_BIT = 0;
	
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="user_role_linker",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;
	
	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;
	
	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $updatedAt;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $locale;
	
    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * Get role.
     *
     * @return Role[]
     */
    public function getRoles()
    {
        return $this->roles->getValues();
    }

    /**
     * Add roles to the user.
     *
     * @param \Doctrine\Common\Collections\Collection $roles
     */
    public function addRoles($roles)
    {
		foreach($roles as $role){
			$this->roles->add($role);
		}
    }
	
	/**
	 * Add a role to the user
	 * @param Role $role
	 */
	public function addRole($role){
		$this->roles->add($role);
	}
	
	/**
	 * Remove roles from the user
	 * 
	 * @param \Doctrine\Common\Collections\Collection $roles
	 */
	public function removeRoles($roles){
		foreach($roles as $role){
			$this->roles->removeElement($role);
		}
	}
	
	/**
	 * @return DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * @return DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}
	
	/**
	 * @param DateTime $createdAt
	 * @return User
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
		return $this;
	}
	
	/**
	 * @param DateTime $updatedAt
	 * @return User
	 */
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
		return $this;
	}
	
	/**
	 * Returns true if the user is active (aka can sign in)
	 * @return bool
	 */
	public function isActive(){
		return $this->getStateBit(static::STATE_ACTIVE_BIT);
	}
	
	/**
	 * Sets the user active state (aka can sign in)
	 * @param bool $isActive
	 */
	public function setIsActive($isActive){
		$this->setStateBit(static::STATE_ACTIVE_BIT, $isActive);
	}
	
	/**
	 * Sets the bit $bit of the user state to $value
	 * @param int $bit
	 * @param bool $value
	 */
	public function setStateBit($bit, $value){
		$this->setState($this->setBitTo($this->getState(), $bit, $value));
	}
	
	/**
	 * Returns the value of the state bit $bit.
	 * @param int $bit
	 * @return bool
	 */
	public function getStateBit($bit){
		return ($this->getState() & (1 << $bit)) !== 0;
	}
	
	/**
	 * Helper function to set a bit in a bitmask and returns the mask
	 * @param int $mask the bitmask
	 * @param int $bit the bit number
	 * @param bool $value the new value
	 * @return bool
	 */
	protected function setBitTo($mask, $bit, $value){
		$mask = $mask & ~(1 << $bit); // delete current value
		return $mask | (!!$value << $bit); // set new value
	}
	
	/** 
	 * @ORM\PrePersist 
	 */  
	public function prePersist()  
	{
		$this->createdAt = new DateTime();
		$this->updatedAt = new DateTime();
	}
	
	/** 
	 * @ORM\PreUpdate 
	 */  
	public function preUpdate()  
	{  
		$this->updatedAt = new DateTime();  
	}
	
	/**
	 * Returns an array containing data of this object
	 * @return array
	 */
	public function getArrayCopy(){
		return $this->jsonSerialize();
	}
	
	/**
	 * Returns displayName
	 * @return string
	 */
	public function __toString(){
		return $this->getDisplayName();
	}
	
	/**
	 * Returns JSON String, representing this object
	 * @return string
	 */
	public function toJson(){
		$data = $this->jsonSerialize();
		return Json::encode($data, true, array('silenceCyclicalExceptions' => true));
	}
	
	/**
	 * Returns array of data, representing this object
	 * @return array
	 */
	public function jsonSerialize(){
		$data = array(
			'user_id' => $this->getId(),
			'username' => $this->getUsername(),
			'email' => $this->getEmail(),
			'displayname' => $this->getDisplayName(),
			'state' => $this->getState(),
			'roles' => $this->getRoles(),
			'createdAt' => $this->getCreatedAt(),
			'updatedAt' => $this->getUpdatedAt(),
			'locale' => $this->getLocale()
		);
		return $data;
	}
}
