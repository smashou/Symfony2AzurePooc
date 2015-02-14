<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Blog;
use AppBundle\Form\Type\BlogType;

class BlogController extends Controller
{
    /**
     * @Route("/{_locale}/blogs", name="blogs", defaults={"_locale" = "en"}, requirements={"_locale" = "%app.locales%"})
     * @Template()
     */
    public function indexAction()
    {
        $blogService = $this->get("app.blog");

        $blogs = $blogService->findAll();

        return [
            'blogs' => $blogs
        ];
    }


    public function blogsAction()
    {
        $blogService = $this->get("app.blog");

        $blogs = $blogService->findAll();

        return $this->render(
            'AppBundle:Nav:blogs.html.twig',
            [
                'blogs' => $blogs
            ]
        );
    }

    /**
     * @Route("/{_locale}/b/{id}", name="blog", defaults={"_locale" = "en"}, requirements={"_locale" = "%app.locales%"}))
     * @Template()
     */
    public function blogAction(Request $request, $id)
    {
        $blogService = $this->get("app.blog");
        $postService = $this->get("app.post");

        $blog  = $blogService->findOneById($id);
        $posts = $postService->findPostsByBlog($blog);

        return [
            "blog"  => $blog,
            "posts" => $posts
        ];
    }

    /**
     * @Route("/{_locale}/blog/new", name="new_blog", defaults={"_locale" = "en"}, requirements={"_locale" = "%app.locales%"}))
     * @Template()
     */
    public function createAction(Request $request)
    {
        $blog = new Blog;

        $form = $this->createForm(new BlogType(), $blog);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $blogService = $this->get("app.blog");
            $blogService ->save($blog);

            return $this->redirect($this->generateUrl('homepage'));
        }

        return [
            'form' => $form->createView()
        ];
    }

}
