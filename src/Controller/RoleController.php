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
    public function sort(Request $request): Response
    {
        $sortBy = $request->query->get('sortBy');
        
        if($sortBy == null || $sortBy == 0)
        {
            // We get all the roles from the database
            $roles = $this->em->getRepository(Role::class)->findAll();

            // We put all our data into a single array
            $data[] = [
                "title" => "Tous les Rôles",
                "titleColor" => "rgb(255, 255, 255)",
                "roles" => $roles
            ];
        }
        else
        {
            // We get all the roles from the database
            $roles = $this->em->getRepository(Role::class)->findAll();

            // We put all our data into a single array
            $data[] = [
                "title" => "nope !",
                "titleColor" => "rgb(0, 255, 0)",
                "roles" => []
            ];
        }

        // We return the HomePage
        return $this->render('roles/sort.html.twig',  ['data' => $data]);
    }
}
