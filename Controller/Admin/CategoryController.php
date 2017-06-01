<?php
/**
 * Created by PhpStorm.
 * User: AntonDachauer
 * Date: 31.05.2017
 * Time: 15:24
 */

namespace FlowFusion\BlogBundle\Controller\Admin;

use FlowFusion\BlogBundle\Entity\Category;
use FlowFusion\BlogBundle\Entity\Post;
use FlowFusion\BlogBundle\Form\CategoryType;
use FlowFusion\BlogBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $pageLimit = $this->getParameter('flow_fusion_blog.loop.page_limit');
        $paginator = $this->get('knp_paginator');
        $paginatedPosts = $paginator->paginate(
            $this->get('flowfusion.blog.admin')->categoryListQuery(),
            $request->query->getInt('page', 1),
            $pageLimit
        );

        $params = [
            'paginatedPosts' => $paginatedPosts,
        ];
        return $this->render('@FlowFusionBlog/Admin/Category/index.html.twig', $params);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $category = $this->get('flowfusion.blog.admin')->getCategory($id);

        if (!is_object($category)) {
            $this->addFlash('error', 'Category with ID #' . $id . ' not found.');
            return $this->redirectToRoute('flow_fusion_blog_admin_category_index');
        }

        $form = $this->createForm(CategoryType::class, $category, [
            'action' => $this->generateUrl('flow_fusion_blog_admin_category_edit', [
                'id' => $id,
            ])
        ]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var Category $data */
                $data = $form->getData();
                $data->setUpdatedAt(new \DateTime());
                $data->setUpdatedBy($this->getUser());

                $this->get('doctrine.orm.default_entity_manager')->persist($data);
                $this->get('doctrine.orm.default_entity_manager')->flush();

                $this->addFlash('error', 'Category with ID #' . $id . ' saved.');
                return $this->redirectToRoute('flow_fusion_blog_admin_category_edit', [
                    'id' => $id,
                ]);
            }
        }

        $params = [
            'category' => $category,
            'form' => $form->createView(),
        ];
        return $this->render('@FlowFusionBlog/Admin/Category/edit.html.twig', $params);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category, [
            'action' => $this->generateUrl('flow_fusion_blog_admin_category_new')
        ]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var Category $data */
                $data = $form->getData();
                $data->setCreatedAt(new \DateTime());
                $data->setCreatedBy($this->getUser());

                $this->get('doctrine.orm.default_entity_manager')->persist($data);
                $this->get('doctrine.orm.default_entity_manager')->flush();

                $this->addFlash('error', 'Category with ID #' . $data->getId() . ' created.');
                return $this->redirectToRoute('flow_fusion_blog_admin_category_edit', [
                    'id' => $data->getId(),
                ]);
            }
        }

        $params = [
            'category' => $category,
            'form' => $form->createView(),
        ];
        return $this->render('@FlowFusionBlog/Admin/Category/create.html.twig', $params);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $category = $this->get('flowfusion.blog.admin')->getCategory($id);

        if (!is_object($category)) {
            $this->addFlash('error', 'Category with ID #' . $id . ' not found.');
            return $this->redirectToRoute('flow_fusion_blog_admin_category_index');
        }

        $this->get('doctrine.orm.default_entity_manager')->remove($category);
        $this->get('doctrine.orm.default_entity_manager')->flush();

        $this->addFlash('error', 'Category with ID #' . $category->getId() . ' deleted.');
        return $this->redirectToRoute('flow_fusion_blog_admin_category_index');
    }
}
