<?php

namespace Application\Main\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{

    public function connectFacebookWithAccountAction()
    {
        $fbService = $this->get('fos_facebook.user.login');
        //todo: check if service is successfully connected.
        $fbService->connectExistingAccount();
        var_dump('logged in by fb'); exit;
        return $this->redirect($this->generateUrl('fos_user_profile_edit'));
    }

    public function loginFbAction() {
        return $this->redirect($this->generateUrl("index"));
    }

}