<?php

namespace App\Controller;

use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RoleController extends AbstractController
{
    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * Page the user first sees
     */
    public function sort(): Response
    {
        // We get all the roles from the database
        $roles = $this->em->getRepository(Role::class)->findAll();

        
        $smallArray = [
                        "title" => "Tous les Rôles",
                        "titleColor" => "rgb(255, 255, 255)",
                        "roles" => $roles
                    ];

        
        $data[] = $smallArray;

        // We return the HomePage
        return $this->render('roles/sort.html.twig',  ['data' => $data]);
    }
}
