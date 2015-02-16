<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
        $note = new Note;

        $form = $this->createForm(new NoteType(), $note);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $noteService = $this->get("app.note");
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

        if(null !== $note) {
            $note->setContent($request->get("content"));
            $noteService->flush();
        }else{
            return new HttpNotFoundException;
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
