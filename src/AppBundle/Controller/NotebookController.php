<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Notebook;
use AppBundle\Form\Type\NotebookType;

class NotebookController extends Controller
{
    /**
     * @Route("/{_locale}/notebook", name="notebooks", defaults={"_locale" = "en"}, requirements={"_locale" = "%app.locales%"})
     * @Template()
     */
    public function indexAction()
    {
        $notebookService = $this->get("app.notebook");
        $securityContext = $this->get('security.context');

        if($securityContext->isGranted("ROLE_USER")){
            $user      = $this->getUser();
            $notebooks = $notebookService->findByUser($user);
        }else{
             $notebooks = $notebookService->findPublic();
        }

        return [
            'notebooks' => $notebooks
        ];
    }


    public function NotebooksAction()
    {
        $notebookService = $this->get("app.notebook");
        $securityContext = $this->get('security.context');

        if($securityContext->isGranted("ROLE_USER")){
            $user      = $this->getUser();
            $notebooks = $notebookService->findByUser($user);
        }else{
             $notebooks = $notebookService->findPublic();
        }

        return $this->render(
            'AppBundle:Nav:notebooks.html.twig',
            [
                'notebooks' => $notebooks
            ]
        );
    }

    /**
     * @Route("/{_locale}/b/{id}", name="notebook", defaults={"_locale" = "en"}, requirements={"_locale" = "%app.locales%"}))
     * @Template()
     */
    public function NotebookAction(Request $request, $id)
    {
        $notebookService = $this->get("app.notebook");
        $noteService = $this->get("app.note");

        $locale = $request->getSession()->get("_locale");

        $notebook  = $notebookService->findOneById($id);

        if (false === $this->get('security.authorization_checker')->isGranted('view', $notebook)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $notes = $noteService->findNotesByNotebook($notebook);

        return [
            "notebook" => $notebook,
            "notes"    => $notes,
            "locale"   => $locale
        ];
    }

    /**
     * @Route("/{_locale}/notebook/new", name="new_notebook", defaults={"_locale" = "en"}, requirements={"_locale" = "%app.locales%"}))
     * @Template()
     */
    public function createAction(Request $request)
    {
        //If the user is not authenticated please register
        if(!$this->isGranted("ROLE_USER")) {

            $this->addFlash("notice", "Please register or login to create a notebook");
            return $this->redirectToRoute("fos_user_registration_register");
        }

        $notebook = new Notebook;

        $form = $this->createForm(new NotebookType(), $notebook);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $notebookService = $this->get("app.notebook");
            $notebook->setUser($this->getUser());
            $notebookService ->save($notebook);

            return $this->redirect($this->generateUrl('homepage'));
        }

        return [
            'form' => $form->createView()
        ];
    }

}
