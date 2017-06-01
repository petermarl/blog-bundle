<?php
/**
 * Created by PhpStorm.
 * User: AntonDachauer
 * Date: 31.05.2017
 * Time: 16:31
 */

namespace FlowFusion\BlogBundle\Service;

use FlowFusion\BlogBundle\Entity\Category;
use FlowFusion\BlogBundle\Entity\Post;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AdminService
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
    public function postListQuery()
    {
        $query = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository('FlowFusionBlogBundle:Post')
            ->createQueryBuilder('p')
            ->leftJoin('p.createdBy', 'u')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery();

        return $query;
    }

    /**
     * @param $id
     * @return Post
     */
    public function getPost($id)
    {
        /** @var Post $post */
        $post = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository('FlowFusionBlogBundle:Post')
            ->find($id);

        return $post;
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    public function categoryListQuery()
    {
        $query = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository('FlowFusionBlogBundle:Category')
            ->createQueryBuilder('c')
            ->leftJoin('c.createdBy', 'u')
            ->orderBy('c.title', 'ASC')
            ->getQuery();

        return $query;
    }

    /**
     * @param $id
     * @return Category
     */
    public function getCategory($id)
    {
        /** @var Category $post */
        $post = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository('FlowFusionBlogBundle:Category')
            ->find($id);

        return $post;
    }

}
