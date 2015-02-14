<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Blog;
use AppBundle\Entity\Post;
use AppBundle\Form\Type\PostType;

class PostController extends Controller
{

    /**
     * @Route("/p/{id}", name="post")
     * @Template()
     */
    public function postAction($id)
    {
        $postService = $this->get("app.post");

        $post = $postService->findOneById($id);

        return [
            "post" => $post
        ];
    }

    /**
     * @Route("/post/new", name="new_post")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $post = new Post;

        $form = $this->createForm(new PostType(), $post);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $postService = $this->get("app.post");
            $postService ->save($post);

            return $this->redirect($this->generateUrl('blogs'));
        }

        return [
            'form' => $form->createView()
        ];
    }


}
