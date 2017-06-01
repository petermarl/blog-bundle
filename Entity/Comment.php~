<?php

namespace FlowFusion\BlogBundle\Entity;

/**
 * Comment
 */
class Comment extends BaseEntity
{
    /**
     * @var string
     */
    private $authorName;

    /**
     * @var string
     */
    private $authorEmail;

    /**
     * @var string
     */
    private $authorUrl;

    /**
     * @var boolean
     */
    private $approved;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $answers;

    /**
     * @var \FlowFusion\BlogBundle\Entity\Post
     */
    private $post;

    /**
     * @var \FlowFusion\BlogBundle\Entity\Comment
     */
    private $answerTo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set authorName
     *
     * @param string $authorName
     *
     * @return Comment
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * Get authorName
     *
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Set authorEmail
     *
     * @param string $authorEmail
     *
     * @return Comment
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    /**
     * Get authorEmail
     *
     * @return string
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * Set authorUrl
     *
     * @param string $authorUrl
     *
     * @return Comment
     */
    public function setAuthorUrl($authorUrl)
    {
        $this->authorUrl = $authorUrl;

        return $this;
    }

    /**
     * Get authorUrl
     *
     * @return string
     */
    public function getAuthorUrl()
    {
        return $this->authorUrl;
    }

    /**
     * Set approved
     *
     * @param boolean $approved
     *
     * @return Comment
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * Get approved
     *
     * @return boolean
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Add answer
     *
     * @param \FlowFusion\BlogBundle\Entity\Comment $answer
     *
     * @return Comment
     */
    public function addAnswer(\FlowFusion\BlogBundle\Entity\Comment $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \FlowFusion\BlogBundle\Entity\Comment $answer
     */
    public function removeAnswer(\FlowFusion\BlogBundle\Entity\Comment $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set post
     *
     * @param \FlowFusion\BlogBundle\Entity\Post $post
     *
     * @return Comment
     */
    public function setPost(\FlowFusion\BlogBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \FlowFusion\BlogBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set answerTo
     *
     * @param \FlowFusion\BlogBundle\Entity\Comment $answerTo
     *
     * @return Comment
     */
    public function setAnswerTo(\FlowFusion\BlogBundle\Entity\Comment $answerTo = null)
    {
        $this->answerTo = $answerTo;

        return $this;
    }

    /**
     * Get answerTo
     *
     * @return \FlowFusion\BlogBundle\Entity\Comment
     */
    public function getAnswerTo()
    {
        return $this->answerTo;
    }
}
