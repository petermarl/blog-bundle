<?php

namespace FlowFusion\BlogBundle\Entity;

/**
 * category
 */
class Category extends BaseEntity
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $childs;

    /**
     * @var \FlowFusion\BlogBundle\Entity\Category
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->childs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Category
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
     * Set description
     *
     * @param string $description
     *
     * @return Category
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
     * Set status
     *
     * @param integer $status
     *
     * @return Category
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add child
     *
     * @param \FlowFusion\BlogBundle\Entity\Category $child
     *
     * @return Category
     */
    public function addChild(\FlowFusion\BlogBundle\Entity\Category $child)
    {
        $this->childs[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \FlowFusion\BlogBundle\Entity\Category $child
     */
    public function removeChild(\FlowFusion\BlogBundle\Entity\Category $child)
    {
        $this->childs->removeElement($child);
    }

    /**
     * Get childs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * Set parent
     *
     * @param \FlowFusion\BlogBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\FlowFusion\BlogBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \FlowFusion\BlogBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add user
     *
     * @param \FlowFusion\BlogBundle\Entity\Post $user
     *
     * @return Category
     */
    public function addUser(\FlowFusion\BlogBundle\Entity\Post $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \FlowFusion\BlogBundle\Entity\Post $user
     */
    public function removeUser(\FlowFusion\BlogBundle\Entity\Post $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
    /**
     * @var boolean
     */
    private $show_in_menu;


    /**
     * Set showInMenu
     *
     * @param boolean $showInMenu
     *
     * @return Category
     */
    public function setShowInMenu($showInMenu)
    {
        $this->show_in_menu = $showInMenu;

        return $this;
    }

    /**
     * Get showInMenu
     *
     * @return boolean
     */
    public function getShowInMenu()
    {
        return $this->show_in_menu;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $posts;


    /**
     * Add post
     *
     * @param \FlowFusion\BlogBundle\Entity\Post $post
     *
     * @return Category
     */
    public function addPost(\FlowFusion\BlogBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \FlowFusion\BlogBundle\Entity\Post $post
     */
    public function removePost(\FlowFusion\BlogBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
