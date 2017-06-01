<?php

namespace FlowFusion\BlogBundle\Twig;

use Doctrine\Common\Proxy\Exception\UnexpectedValueException;
use FlowFusion\BlogBundle\Service\BlogService;

class FFBlogExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('post_status', array($this, 'postStatus')),
        );
    }

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
