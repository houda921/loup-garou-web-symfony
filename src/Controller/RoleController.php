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
            // Adding faction : Villageois
            $data[] = [
                "title" => "Villageois",
                "titleColor" => "#1e88e5",
                "roles" => $this->em->getRepository(Role::class)->findByField("id_faction", 1)
            ];

            // Adding faction : Loups-Garou
            $data[] = [
                "title" => "Loups-Garou",
                "titleColor" => "#7b1b24",
                "roles" => $this->em->getRepository(Role::class)->findByField("id_faction", 2)
            ];

            // Adding faction : Indépendants
            $data[] = [
                "title" => "Indépendants",
                "titleColor" => "#1de9b6",
                "roles" => $this->em->getRepository(Role::class)->findByField("id_faction", 3)
            ];
        }

        // We return the HomePage
        return $this->render('roles/sort.html.twig',  ['data' => $data]);
    }
}
