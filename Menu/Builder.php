<?php
/**
 * Created by PhpStorm.
 * User: AntonDachauer
 * Date: 01.06.2017
 * Time: 15:36
 */

namespace FlowFusion\BlogBundle\Menu;

use FlowFusion\BlogBundle\Entity\Category;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class Builder
 * @package FlowFusion\BlogBundle\Menu
 */
class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function categoriesMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->addChild('Home', array('route' => 'flow_fusion_blog_index'));

        $categories = $this->container->get('flowfusion.blog')->getMenuCategories();

        if (sizeof($categories) > 0) {
            /** @var Category $category */
            foreach ($categories as $category) {
                $menu->addChild($category->getTitle(), [
                    'route' => 'flow_fusion_blog_category_index',
                    'routeParameters' => [
                        'slug' => $this->container->get('flowfusion.slugify')->slugify($category->getTitle()),
                        'id' => $category->getId(),
                    ]
                ]);
            }
        }

        return $menu;
    }

    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function adminPostsMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->addChild('Posts overview', array('route' => 'flow_fusion_blog_admin_post_index'));
        $menu->addChild('Create post', array('route' => 'flow_fusion_blog_admin_post_new'));

        return $menu;
    }

    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function adminCategoriesMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->addChild('Categories overview', array('route' => 'flow_fusion_blog_admin_category_index'));
        $menu->addChild('Create category', array('route' => 'flow_fusion_blog_admin_category_new'));

        return $menu;
    }
}
