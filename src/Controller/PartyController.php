<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Party;
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
        $parties = $this->em->getRepository(Party::class)->findBy([
            'is_open' => true,
        ]);

        // We return the correct page
        return $this->render('parties/lobby.html.twig',  ['parties' => $parties]);
    }



    /**
     * Creation of a new Party
     */
    public function new(Request $request): Response
    {
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
                $isValid = (isset($data["name"]));
                
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
                    $newParty->setCreator( $user );
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

            // If reached : something went wrong with the Login
            return $this->render('accounts/connection.html.twig', [
                'errorMessage' => $errorMessage
                ]);
        }


        // The user just arrived on the page :
        // We return the Creation page
        return $this->render('parties/new.html.twig');
    }


    /**
     * Display a Party (given the ID in the url)
     * The method automatically searches for a Party of id given accordingly to the route
     */
    public function show(Party $party): Response
    {
        // If the spaceship was not found (= is null)
        if( !$party )
        {
            throw $this->createNotFoundException('Party #' . $id . ' not found !');
        }
        if( !$party->getIsOpen() )
        {
            throw $this->createNotFoundException('Party #' . $id . ' is closed !');
        }

         //  we return the page displaying a SINGLE Spaceship
         return $this->render('parties/show.html.twig', compact('party'));
    }
}