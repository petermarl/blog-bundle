<?php

namespace FlowFusion\BlogBundle\Twig;

use Doctrine\Common\Proxy\Exception\UnexpectedValueException;
use FlowFusion\BlogBundle\Service\BlogService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class FFBlogExtension
 * @package FlowFusion\BlogBundle\Twig
 */
class FFBlogExtension extends \Twig_Extension
{

    private $container;

    /**
     * FFBlogExtension constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('post_status', array($this, 'postStatus')),
            new \Twig_SimpleFilter('slugify', array($this, 'slugify')),
        );
    }

    /**
     * @param $value
     * @return string
     */
    public function slugify($value)
    {
        return $this->container->get('flowfusion.slugify')->slugify($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function postStatus($value)
    {
        if (!is_numeric($value)) {
            throw new UnexpectedValueException('Value must be a integer.');
        }

        switch ($value) {
            case BlogService::POST_STATUS_DELETED:
                return 'deleted';
            case BlogService::POST_STATUS_PUBLISHED:
                return 'published';
            case BlogService::POST_STATUS_DRAFT:
                return 'draft';
            default:
                return 'unknown';
        }
    }
}
