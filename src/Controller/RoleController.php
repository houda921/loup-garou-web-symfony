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
        $allowed = [0, 1];
        $sortBy = $request->query->get('sortBy');
        $data = [];
        
        // If the user tries to sort by an unallowed criteria : ERROR
        if($sortBy != null && !in_array($sortBy, $allowed))
        {
            throw $this->createNotFoundException("You cannot sort Roles by this !");
        }

        // Default case : get all Roles
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
        // Sort by Factions
        elseif($sortBy == 1)
        {
            $data = $this->em->getRepository(Role::class)->orderByFactionsArrays();
        }

        // We return the HomePage
        return $this->render('roles/sort.html.twig',  ['data' => $data]);
    }
}
