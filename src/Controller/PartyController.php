<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Party;
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
    public function lobby(Request $request): Response
    {
        // Just in case : we initialize the error message
        $errorMessage = "";


        // POST request -> the form was validated, we now perform some validations
        if ($request->isMethod('POST'))
        {
            // We get the data
            $data = $request->request->all();

            // CSRF verification
            if( $this->isCsrfTokenValid('party_create', $data['token']) )
            {
                // We check if the form's entries are valid
                // Do more verifications if needed :)
                $isValid = (isset($data["name"]) && strlen($data["name"]) <= 25);
                
                // If the data entered by the user are invalid : ERROR
                if (!$isValid)
                {
                    $errorMessage = "Please verify your inputs";
                }
                // The data are valid : proceed !
                else
                {
                    // We get the SESSION object and the ID of the user
                    $session = $this->get('session');
                    $user = $this->em->getRepository(Account::class)->findOneBy(['id' => $session->get('userID')]);

                    // We create a new Party
                    $newParty = new Party();
                    $newParty->setName( $data["name"] );
                    $newParty->setAdmin( $user );
                    $newParty->addPlayer( $user );

                    // We push it into the database
                    $this->em->persist($newParty);
                    $this->em->flush();

                    // redirect the user to the mainPage
                    return $this->redirectToRoute('party_show', ['id' => $newParty->getId()]);
                }
            }
            // CRSF is incorrect !
            else
            {
                $errorMessage = "hmm, this unusual... have you ever heard of CSRF ?";
            }
        }


        // We get all the parties
        $parties = $this->em->getRepository(Party::class)->findBy([
            'is_open' => true,
        ]);

        // If reached : display the regular page (with a possibly filled error message)
        return $this->render('parties/lobby.html.twig', [
            'parties' => $parties,
            'errorMessage' => $errorMessage
        ]);
    }




    /**
     * Display a Party (given the ID in the url)
     * The method automatically searches for a Party of id given accordingly to the route
     * If no Party could be found, an error 404 will be generated
     */
    public function show(Request $request, Party $party): Response
    {
        // If the Party is not open
        if( !$party->getIsOpen() )
        {
            // Throw error
            throw $this->createNotFoundException('Party #' . $id . ' is closed !');
        }
        
        
        // POST request -> the form was validated, we now perform some validations
        if ($request->isMethod('POST'))
        {
            // We get the data
            $data = $request->request->all();
            dd($data);
        }


        // We get all the roles by Faction
        $roles = $this->em->getRepository(Role::class)->orderByFactions();

         //  we return the page displaying a SINGLE Spaceship
         return $this->render('parties/show.html.twig',  ['party' => $party, 'roles' => $roles]);
    }


    /**
     * Display all statistics from finished parties
     */
    public function stats(Request $request): Response
    {
         //  we return the page displaying the statistics
         return $this->render('parties/stats.html.twig');
    }
}