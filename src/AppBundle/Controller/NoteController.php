<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Notebook;
use AppBundle\Entity\Note;
use AppBundle\Form\Type\NoteType;

class NoteController extends Controller
{

    /**
     * @Route("/{_locale}/no/{id}", name="note", defaults={"_locale" = "en"}, requirements={"_locale" = "%app.locales%"}))
     * @Template()
     */
    public function noteAction($id)
    {
        $noteService = $this->get("app.note");

        $note = $noteService->findOneById($id);

        if (false === $this->get('security.authorization_checker')->isGranted('view', $note)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $notebook = $note->getNotebook();

        return [
            "note"     => $note,
            "notebook" => $notebook
        ];
    }

    /**
     * @Route("/{_locale}/note/new", name="new_note", defaults={"_locale" = "en"}, requirements={"_locale" = "%app.locales%"}))
     * @Template()
     */
    public function createAction(Request $request)
    {
        //If the user is not authenticated please register
        if(!$this->isGranted("ROLE_USER")) {

            $this->addFlash("notice", "Please register or login to create a note");
            return $this->redirectToRoute("fos_user_registration_register");
        }

        $note = new Note;

        $form = $this->createForm(new NoteType(), $note);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $noteService = $this->get("app.note");

            $note->setUser($this->getUser());
            $noteService ->save($note);

            return $this->redirect($this->generateUrl('notebook', ["id" => $note->getNotebook()->getId()]));
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/{_locale}/note/up/{id}", name="update_note", defaults={"_locale" = "en"}, requirements={"_locale" = "%app.locales%"}))
     * @Template()
     */
    public function updateAjaxAction(Request $request, $id)
    {
        $noteService = $this->get("app.note");
        $note        = $noteService->findOneById($id);

        if (false === $this->get('security.authorization_checker')->isGranted('edit', $note)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        if(null !== $note) {
            $note->setContent($request->get("content"));
            $noteService->save($note);
        }else{
            $this->createNotFoundException("Note Not Found");
        }

        return ["ok"];
    }

    /**
     * @Route("/{_locale}/note/u/{id}", name="update_note", defaults={"_locale" = "en"}, requirements={"_locale" = "%app.locales%"}))
     * @Template()
     */
    public function updateAction(Request $request, $id)
    {
        $noteService = $this->get("app.note");

        $note = $noteService->findOneById($id);

        if(null === $note) {
            $this->createNotFoundException("Note Not Found");
        }

        if (false === $this->get('security.authorization_checker')->isGranted('edit', $note)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new NoteType(), $note);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $noteService = $this->get("app.note");
            $noteService ->save($note);

            return $this->redirect($this->generateUrl('notebook', ["id" => $note->getNotebook()->getId()]));
        }

        return [
            'note' => $note,
            'form' => $form->createView()
        ];

    }


}
