<?php

namespace FlowFusion\BlogBundle\Entity;

/**
 * BaseEntity
 */
class BaseEntity
{

    public function __toString()
    {
        if (method_exists($this, 'getTitle')) {
            return $this->getTitle();
        }

        return $this->id;
    }

    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return BaseEntity
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
     *
     * @return BaseEntity
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
     * @var \FOS\UserBundle\Model\User
     */
    private $createdBy;

    /**
     * @var \FOS\UserBundle\Model\User
     */
    private $updatedBy;


    /**
     * Set createdBy
     *
     * @param \FOS\UserBundle\Model\User $createdBy
     *
     * @return BaseEntity
     */
    public function setCreatedBy(\FOS\UserBundle\Model\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \FOS\UserBundle\Model\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param \FOS\UserBundle\Model\User $updatedBy
     *
     * @return BaseEntity
     */
    public function setUpdatedBy(\FOS\UserBundle\Model\User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \FOS\UserBundle\Model\User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
}
