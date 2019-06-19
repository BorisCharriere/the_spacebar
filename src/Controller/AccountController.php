<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends BaseController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function index()
    {
        $this->getUser();
        return $this->render('account/index.html.twig', [

        ]);
    }
}
