<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Party;
use App\Entity\Player;
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

                    // We create the first player of the party (we don't give it any role, for the time being)
                    $firstPlayer = new Player();
                    $firstPlayer->setParty( $newParty );
                    $firstPlayer->setIsPartyAdmin( true );
                    $firstPlayer->setAccount( $user );
                    
                    $newParty->addPlayer( $firstPlayer );

                    // We push them into the database
                    $this->em->persist($newParty);
                    $this->em->persist($firstPlayer);
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

        // dd($parties[0]->getPlayers()[0]);


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
        

        // We get all the roles by Faction
        $roles = $this->em->getRepository(Role::class)->orderByFactions();

        
        // POST request -> the form was validated, we now perform some validations
        if ($request->isMethod('POST'))
        {
            // We initialize a counter for the roles (they are ordered in the SAME WAY)
            $cptRole = 0;
            // We get the data
            $data = $request->request->all();

            foreach ($data as $id => $value) {
                // We setup the current role
                $currentRole = $roles[$cptRole++];

                // We set some counters
                $cptCurrent = $party->getCptRole($currentRole);
                $cptToReach = intval($value);

                // We want to ADD Roles
                if($cptCurrent < $cptToReach)
                {
                    for ($i = $cptCurrent; $i < $cptToReach; $i++) {
                        // We create a new Player
                        $newPlayer = new Player();
                        $newPlayer->setRole( $currentRole );
                        $newPlayer->setParty( $party );
    
    
                        // We update the party
                        $party->addPlayer( $newPlayer );
    
                        // We Save the "fake" new Player into the database
                        $this->em->persist($newPlayer);
                    }

                    // We save the party's updates
                    $this->em->persist($party);
                }
                // We want to REMOVE Roles
                elseif($cptCurrent > $cptToReach)
                {
                    // We get all the players of the current Role
                    $players = $party->getSetUpRoles();
                    $playersOfThisRole = [];
                    foreach ($players as $p) {
                        if($p->getRole() == $currentRole)
                        {
                            $playersOfThisRole[] = $p;
                        }
                    }


                    for ($i = 0; $i < $cptCurrent - $cptToReach; $i++) {
                        // We get the Player to remove
                        $removedPlayer = $playersOfThisRole[$i];

                        // We remove the Player from the Party
                        $party->removePlayer($removedPlayer);

                        // We remove the Player from the database
                        $this->em->remove($removedPlayer);
                    }

                    // We save the party's updates
                    $this->em->persist($party);
                }
            }
            
            // We push all changes into the database
            $this->em->flush();
        }

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