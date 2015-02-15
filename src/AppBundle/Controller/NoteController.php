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
     * @Route("/{_locale}/note/{id}", name="note", defaults={"_locale" = "en"}, requirements={"_locale" = "%app.locales%"}))
     * @Template()
     */
    public function noteAction($id)
    {
        $noteService = $this->get("app.note");

        $note = $noteService->findOneById($id);

        return [
            "note" => $note
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

            return $this->redirect($this->generateUrl('notebooks'));
        }

        return [
            'form' => $form->createView()
        ];
    }


}
