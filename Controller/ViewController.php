<?php

namespace FlowFusion\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ViewController extends Controller
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
            $this->get('flowfusion.blog')->loopQuery(),
            $request->query->getInt('page', 1),
            $pageLimit
        );

        $params = [
            'paginatedPosts' => $paginatedPosts,
        ];
        return $this->render('FlowFusionBlogBundle:View:index.html.twig', $params);
    }

    /**
     * @param Request $request
     * @param $username
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function authorIndexAction(Request $request, $username)
    {
        $pageLimit = $this->getParameter('flow_fusion_blog.loop.page_limit');
        $paginator = $this->get('knp_paginator');
        $paginatedPosts = $paginator->paginate(
            $this->get('flowfusion.blog')->authorLoopQuery($username),
            $request->query->getInt('page', 1),
            $pageLimit
        );

        $user = $this->get('flowfusion.blog')->getUserByUsername($username);

        $params = [
            'paginatedPosts' => $paginatedPosts,
            'author' => $user,
        ];
        return $this->render('FlowFusionBlogBundle:View:index.html.twig', $params);
    }

    /**
     * @param Request $request
     * @param $slug
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryIndexAction(Request $request, $slug, $id)
    {
        $pageLimit = $this->getParameter('flow_fusion_blog.loop.page_limit');
        $paginator = $this->get('knp_paginator');
        $paginatedPosts = $paginator->paginate(
            $this->get('flowfusion.blog')->categoryLoopQuery($id),
            $request->query->getInt('page', 1),
            $pageLimit
        );

        $category = $this->get('flowfusion.blog')->getCategoryById($id);

        $params = [
            'paginatedPosts' => $paginatedPosts,
            'category' => $category,
        ];
        return $this->render('FlowFusionBlogBundle:View:index.html.twig', $params);
    }

    /**
     * @param Request $request
     * @param $slug
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tagIndexAction(Request $request, $slug, $id)
    {
        $pageLimit = $this->getParameter('flow_fusion_blog.loop.page_limit');
        $paginator = $this->get('knp_paginator');
        $paginatedPosts = $paginator->paginate(
            $this->get('flowfusion.blog')->tagLoopQuery($id),
            $request->query->getInt('page', 1),
            $pageLimit
        );

        $tag = $this->get('flowfusion.blog')->getTagById($id);

        $params = [
            'paginatedPosts' => $paginatedPosts,
            'tag' => $tag,
        ];
        return $this->render('FlowFusionBlogBundle:View:index.html.twig', $params);
    }

    /**
     * @param Request $request
     * @param $y
     * @param $m
     * @param $d
     * @param $slug
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request, $y, $m, $d, $slug, $id)
    {
        $post =  $this->get('flowfusion.blog')->getPostById($id);
        if (!is_object($post)) {
            $this->addFlash('error', 'Post with ID '. $id. ' not found.');
        }

        $params = [
            'post' => $post,
        ];
        return $this->render('@FlowFusionBlog/View/post.html.twig', $params);
    }
}
