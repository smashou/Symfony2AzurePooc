<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/{_locale}", name="homepage", defaults={"_locale" = "en"}, requirements={"_locale" = "%app.locales%"}))
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $notebookService = $this->get("app.notebook");
        $noteService     = $this->get("app.note");

        if($this->isGranted("ROLE_USER")) {
            $notebooks = $notebookService->findAll();
        }else{
            $notebooks = null;
        }

        $notes     = $noteService->findLasts();
        $locale    = $request->getSession()->get("_locale");

        return [
            'notes'     => $notes,
            'locale'    => $locale,
            'notebooks' => $notebooks
        ];
    }
}
