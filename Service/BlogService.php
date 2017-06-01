<?php

namespace FlowFusion\BlogBundle\Service;

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
            ->getRepository('FlowFusionBlogBundle:Post')
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
            ->getRepository('FlowFusionBlogBundle:Post')
            ->createQueryBuilder('p')
            ->leftJoin('p.createdBy', 'u')
            ->where('p.status = :status')
            ->andWhere('u.username = :username')
            ->setParameter('status', self::POST_STATUS_PUBLISHED)
            ->setParameter('username', $username)
            ->getQuery();

        return $query;
    }

    public function userExists($username)
    {
        $query = $this->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository('FlowFusionUserBundle:User')
            ->createQueryBuilder('u')
            ->where('u.username = :username')
            ->getQuery();

        $result = $query->getOneOrNullResult();

        return is_object($result);
    }
}
