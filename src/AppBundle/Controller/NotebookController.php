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
        $notebook = new Notebook;

        $form = $this->createForm(new NotebookType(), $notebook);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $notebookService = $this->get("app.notebook");
            $notebookService ->save($notebook);

            return $this->redirect($this->generateUrl('homepage'));
        }

        return [
            'form' => $form->createView()
        ];
    }

}
