<?php
/**
 * Created by PhpStorm.
 * User: AntonDachauer
 * Date: 31.05.2017
 * Time: 15:24
 */

namespace FlowFusion\BlogBundle\Controller\Admin;

use FlowFusion\BlogBundle\Entity\Tag;
use FlowFusion\BlogBundle\Form\TagType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TagController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $pageLimit = $this->getParameter('flow_fusion_blog.loop.page_limit');
        $paginator = $this->get('knp_paginator');
        $paginated = $paginator->paginate(
            $this->get('flowfusion.blog.admin')->tagListQuery(),
            $request->query->getInt('page', 1),
            $pageLimit
        );

        $params = [
            'tags' => $paginated,
        ];
        return $this->render('@FlowFusionBlog/Admin/Tag/index.html.twig', $params);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $tag = $this->get('flowfusion.blog.admin')->getTag($id);

        if (!is_object($tag)) {
            $this->addFlash('error', 'Tag with ID #' . $id . ' not found.');
            return $this->redirectToRoute('flow_fusion_blog_admin_tag_index');
        }

        $form = $this->createForm(TagType::class, $tag, [
            'action' => $this->generateUrl('flow_fusion_blog_admin_tag_edit', [
                'id' => $id,
            ])
        ]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var Tag $data */
                $data = $form->getData();
                $data->setUpdatedAt(new \DateTime());
                $data->setUpdatedBy($this->getUser());

                $this->get('doctrine.orm.default_entity_manager')->persist($data);
                $this->get('doctrine.orm.default_entity_manager')->flush();

                $this->addFlash('error', 'Tag with ID #' . $id . ' saved.');
                return $this->redirectToRoute('flow_fusion_blog_admin_tag_edit', [
                    'id' => $id,
                ]);
            }
        }

        $params = [
            'tag' => $tag,
            'form' => $form->createView(),
        ];
        return $this->render('@FlowFusionBlog/Admin/Tag/edit.html.twig', $params);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $tag = new Tag();

        $form = $this->createForm(TagType::class, $tag, [
            'action' => $this->generateUrl('flow_fusion_blog_admin_tag_new')
        ]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var Tag $data */
                $data = $form->getData();
                $data->setCreatedAt(new \DateTime());
                $data->setCreatedBy($this->getUser());

                $this->get('doctrine.orm.default_entity_manager')->persist($data);
                $this->get('doctrine.orm.default_entity_manager')->flush();

                $this->addFlash('error', 'Tag with ID #' . $data->getId() . ' created.');
                return $this->redirectToRoute('flow_fusion_blog_admin_tag_edit', [
                    'id' => $data->getId(),
                ]);
            }
        }

        $params = [
            'tag' => $tag,
            'form' => $form->createView(),
        ];
        return $this->render('@FlowFusionBlog/Admin/Tag/create.html.twig', $params);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $tag = $this->get('flowfusion.blog.admin')->getTag($id);

        if (!is_object($tag)) {
            $this->addFlash('error', 'Tag with ID #' . $id . ' not found.');
            return $this->redirectToRoute('flow_fusion_blog_admin_tag_index');
        }

        $this->get('doctrine.orm.default_entity_manager')->remove($tag);
        $this->get('doctrine.orm.default_entity_manager')->flush();

        $this->addFlash('error', 'Tag with ID #' . $tag->getId() . ' deleted.');
        return $this->redirectToRoute('flow_fusion_blog_admin_tag_index');
    }
}
