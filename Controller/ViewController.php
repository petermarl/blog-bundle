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
            $this->get('flowfusion.blog')->loopQuery(),
            $request->query->getInt('page', 1),
            $pageLimit
        );

        $params = [
            'paginatedPosts' => $paginatedPosts,
        ];
        return $this->render('FlowFusionBlogBundle:View:index.html.twig', $params);
    }

}
