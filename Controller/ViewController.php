<?php

namespace FlowFusion\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function _404Action(Request $request)
    {
        $response = new Response();
        $response->setStatusCode(404);
        return $this->render('FlowFusionBlogBundle:View:404.html.twig', [], $response);
    }

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

        $response = new Response();
        if (sizeof($paginatedPosts) == 0) {
            $response->setStatusCode(404);
        }
        return $this->render('FlowFusionBlogBundle:View:index.html.twig', $params, $response);
    }

    /**
     * @param Request $request
     * @param $username
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function authorIndexAction(Request $request, $username)
    {
        if (!is_object($this->get('flowfusion.blog')->getUserByUsername($username))) {
            return $this->redirectToRoute('flow_fusion_blog_404');
        }

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

        $response = new Response();
        if (sizeof($paginatedPosts) == 0) {
            $response->setStatusCode(404);
        }
        return $this->render('FlowFusionBlogBundle:View:index.html.twig', $params, $response);
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

        $response = new Response();
        if (sizeof($paginatedPosts) == 0) {
            $response->setStatusCode(404);
        }
        return $this->render('FlowFusionBlogBundle:View:index.html.twig', $params, $response);
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

        $response = new Response();
        if (sizeof($paginatedPosts) == 0) {
            $response->setStatusCode(404);
        }
        return $this->render('FlowFusionBlogBundle:View:index.html.twig', $params, $response);
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
        $post = $this->get('flowfusion.blog')->getPostById($id);
        if (!is_object($post)) {
            return $this->redirectToRoute('flow_fusion_blog_404');
        }

        $params = [
            'post' => $post,
        ];
        return $this->render('@FlowFusionBlog/View/post.html.twig', $params);
    }
}
