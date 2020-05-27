<?php

namespace App\Controller;

use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PartyController extends AbstractController
{
    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * Displays all the Parties, and allows to create a new one
     */
    public function show(Request $request): Response
    {
        /*
        $data[] = [
            "name" => "Obamacare",
            "creator" => "Hugues",
            "player_current" => 5,
            "player_max" => 8
        ];
        $data[] = [
            "name" => "Obamacare",
            "creator" => "Hugues",
            "player_current" => 5,
            "player_max" => 8
        ];
        $data[] = [
            "name" => "Obamacare",
            "creator" => "Hugues",
            "player_current" => 5,
            "player_max" => 8
        ];
        $data[] = [
            "name" => "Obamacare",
            "creator" => "Hugues",
            "player_current" => 5,
            "player_max" => 8
        ];
        */
        $data = [];

        // We return the correct page
        return $this->render('parties/show.html.twig',  ['data' => $data]);
    }
}
