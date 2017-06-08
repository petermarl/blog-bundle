<?php

namespace FlowFusion\BlogBundle\Service;

use FlowFusion\BlogBundle\Entity\Category;
use FlowFusion\BlogBundle\Entity\Post;
use FlowFusion\BlogBundle\Entity\Tag;
use FlowFusion\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Created by PhpStorm.
 * User: AntonDachauer
 * Date: 31.05.2017
 * Time: 13:37
 */
class BlogService
{

    const POST_STATUS_DRAFT = 0;
    const POST_STATUS_PUBLISHED = 1;
    const POST_STATUS_DELETED = 2;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * BlogService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    public function loopQuery()
    {
        $query = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository(Post::class)
            ->createQueryBuilder('p')
            ->where('p.status = :status')
            ->setParameter('status', self::POST_STATUS_PUBLISHED)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery();

        return $query;
    }

    /**
     * @param $username
     * @return \Doctrine\ORM\Query
     */
    public function authorLoopQuery($username)
    {
        $query = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository(Post::class)
            ->createQueryBuilder('p')
            ->leftJoin('p.createdBy', 'u')
            ->where('p.status = :status')
            ->andWhere('u.username = :username')
            ->setParameter('status', self::POST_STATUS_PUBLISHED)
            ->setParameter('username', $username)
            ->getQuery();

        return $query;
    }

    /**
     * @param $id
     * @return \Doctrine\ORM\Query
     */
    public function categoryLoopQuery($id)
    {
        $query = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository(Post::class)
            ->createQueryBuilder('p')
            ->leftJoin('p.categories', 'c')
            ->where('p.status = :status')
            ->andWhere('c.status = :status')
            ->andWhere('c.id = :cid')
            ->setParameter('status', self::POST_STATUS_PUBLISHED)
            ->setParameter('cid', $id)
            ->getQuery();

        return $query;
    }

    /**
     * @param $id
     * @return \Doctrine\ORM\Query
     */
    public function tagLoopQuery($id)
    {
        $query = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository(Post::class)
            ->createQueryBuilder('p')
            ->leftJoin('p.tags', 't')
            ->where('p.status = :status')
            ->andWhere('t.status = :status')
            ->andWhere('t.id = :tid')
            ->setParameter('status', self::POST_STATUS_PUBLISHED)
            ->setParameter('tid', $id)
            ->getQuery();

        return $query;
    }

    /**
     * @param $id
     * @return Category
     */
    public function getCategoryById($id)
    {
        /** @var Category $category */
        $category = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository(Category::class)
            ->find($id);

        return $category;
    }

    /**
     * @param $id
     * @return Tag
     */
    public function getTagById($id)
    {
        /** @var Tag $category */
        $tag = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository(Tag::class)
            ->find($id);

        return $tag;
    }

    /**
     * @param $username
     * @return User
     */
    public function getUserByUsername($username)
    {
        $query = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.username = :username')
            ->setParameter('username', $username)
            ->getQuery();

        /** @var User $result */
        $result = $query->getOneOrNullResult();

        return $result;
    }

    /**
     * @return array
     */
    public function getMenuCategories()
    {
        $categories = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository(Category::class)
            ->createQueryBuilder('c')
            ->where('c.status = :status')
            ->andWhere('c.show_in_menu = :sim')
            ->setParameter('sim', true)
            ->setParameter('status', self::POST_STATUS_PUBLISHED)
            ->orderBy('c.title', 'DESC')
            ->getQuery()
            ->getResult();

        return $categories;
    }

    /**
     * @param $id
     * @return Post
     */
    public function getPostById($id)
    {
        $post = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository(Post::class)
            ->find($id);

        return $post;
    }
}
