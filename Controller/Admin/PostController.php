<?php
/**
 * Created by PhpStorm.
 * User: AntonDachauer
 * Date: 31.05.2017
 * Time: 15:24
 */

namespace FlowFusion\BlogBundle\Controller\Admin;

use FlowFusion\BlogBundle\Entity\Post;
use FlowFusion\BlogBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
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
            $this->get('flowfusion.blog.admin')->postListQuery(),
            $request->query->getInt('page', 1),
            $pageLimit
        );

        $params = [
            'paginatedPosts' => $paginatedPosts,
        ];
        return $this->render('@FlowFusionBlog/Admin/Post/index.html.twig', $params);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $post = $this->get('flowfusion.blog.admin')->getPost($id);

        if (!is_object($post)) {
            $this->addFlash('error', 'Post with ID #' . $id . ' not found.');
            return $this->redirectToRoute('flow_fusion_blog_admin_post_index');
        }

        $form = $this->createForm(PostType::class, $post, [
            'action' => $this->generateUrl('flow_fusion_blog_admin_post_edit', [
                'id' => $id,
            ])
        ]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var Post $data */
                $data = $form->getData();
                $data->setUpdatedAt(new \DateTime());
                $data->setUpdatedBy($this->getUser());

                $this->get('doctrine.orm.default_entity_manager')->persist($data);
                $this->get('doctrine.orm.default_entity_manager')->flush();

                $this->addFlash('error', 'Post with ID #' . $id . ' saved.');
                return $this->redirectToRoute('flow_fusion_blog_admin_post_edit', [
                    'id' => $id,
                ]);
            }
        }

        $params = [
            'post' => $post,
            'form' => $form->createView(),
        ];
        return $this->render('@FlowFusionBlog/Admin/Post/edit.html.twig', $params);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post, [
            'action' => $this->generateUrl('flow_fusion_blog_admin_post_new')
        ]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var Post $data */
                $data = $form->getData();
                $data->setCreatedAt(new \DateTime());
                $data->setCreatedBy($this->getUser());

                $this->get('doctrine.orm.default_entity_manager')->persist($data);
                $this->get('doctrine.orm.default_entity_manager')->flush();

                $this->addFlash('error', 'Post with ID #' . $data->getId() . ' created.');
                return $this->redirectToRoute('flow_fusion_blog_admin_post_edit', [
                    'id' => $data->getId(),
                ]);
            }
        }

        $params = [
            'post' => $post,
            'form' => $form->createView(),
        ];
        return $this->render('@FlowFusionBlog/Admin/Post/edit.html.twig', $params);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $post = $this->get('flowfusion.blog.admin')->getPost($id);

        if (!is_object($post)) {
            $this->addFlash('error', 'Post with ID #' . $id . ' not found.');
            return $this->redirectToRoute('flow_fusion_blog_admin_post_index');
        }

        $this->get('doctrine.orm.default_entity_manager')->remove($post);
        $this->get('doctrine.orm.default_entity_manager')->flush();

        $this->addFlash('error', 'Post with ID #' . $post->getId() . ' deleted.');
        return $this->redirectToRoute('flow_fusion_blog_admin_post_index');
    }
}
