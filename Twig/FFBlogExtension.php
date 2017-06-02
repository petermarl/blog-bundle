<?php

namespace FlowFusion\BlogBundle\Twig;

use Doctrine\Common\Proxy\Exception\UnexpectedValueException;
use FlowFusion\BlogBundle\Entity\Post;
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
            new \Twig_SimpleFilter('excerpt', array($this, 'excerpt')),
        );
    }

    public function excerpt($value, Post $post = null)
    {
        $maxLength = $this->container->getParameter('flow_fusion_blog.loop.excerpt_length');
        $readMore = $this->container->getParameter('flow_fusion_blog.loop.read_more_link');

        $excerpt = substr($value, 0, $maxLength). '...';
        if ($readMore == true) {
            if (is_null($post)) {
                throw new \InvalidArgumentException('You must provide the post object to show the "read more" link on excerpt.');
            }
            $postDate = $post->getCreatedAt();
            $url = $this->container->get('router')->generate('flow_fusion_blog_post_show', [
                'y' => $postDate->format('Y'),
                'm' => $postDate->format('m'),
                'd' => $postDate->format('d'),
                'slug' => $this->slugify($post->getTitle()),
                'id' => $post->getId(),
            ]);

            $excerpt .= ' <a href="'. $url. '">read more';
        }

        return $excerpt;
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
