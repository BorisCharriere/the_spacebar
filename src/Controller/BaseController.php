<?php

namespace App\Controller;

use App\Entity\User;
use http\Exception\UnexpectedValueException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    protected function getUser(): User
    {
        $user = parent::getUser();
        if (! $user instanceof User){
            throw new UnexpectedValueException("User must be instance of User");
        }
        return $user;
    }
}