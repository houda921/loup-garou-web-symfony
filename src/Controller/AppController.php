<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\Party;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AppController extends AbstractController
{
    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * Page the user first sees
     */
    public function homepage(): Response
    {
        // We get all the roles from the database
        $roles = $this->em->getRepository(Role::class)->findAll();

        // We return the HomePage
        return $this->render('homepage.html.twig',  ['roles' => $roles]);
    }
}
