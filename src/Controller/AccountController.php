<?php

namespace App\Controller;

use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends AbstractController
{
    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Page disconnecting the user
     */
    public function logOut(): Response
    {
        // We get the SESSION object
        $session = $this->get('session');
        $isLogged = $session->get('userID');

        // If the user is logged : he is ALLOWED to log out
        if($isLogged)
        {
            // We reset some SESSION variables
            $session->set('userID', 0);
            $session->set('isAdmin', false);
        }

        // We redirect the user to the homepage, whatever the result is
        return $this->redirect($this->generateUrl('homepage'));
    }


    /**
     * Page where the user can create an account / connect to his account
     * @return Response either the connection page or the homepage, depending on whether the user is already logged or not
     */
    public function connection(Request $request): Response
    {
        // We get the SESSION object
        $session = $this->get('session');
        $isLogged = ($session->get('userID') != 0);

        // If the user is already logged : error, he cannot access this page
        // --> redirected to the homepage
        if($isLogged)
        {
            // redirect the user to the homepage
            return $this->redirectToRoute('homepage');
        }

        // POST request -> the form was validated, we now perform some validations
        if ($request->isMethod('POST'))
        {
            // We get the data
            $data = $request->request->all();

            // LOGIN
            if( $this->isCsrfTokenValid('account_login', $data['token']) )
            {
                // We check if the form's entries are valid
                // Do more verifications if needed :)
                $isValid = (isset($data["username"]) && strlen($data["username"]) <= 20 && isset($data["password"]));
                
                // If the data entered by the user are invalid : ERROR
                if (!$isValid)
                {
                    $errorMessageLogin = "Please verify your inputs";
                }
                // The data are valid : proceed !
                else
                {
                    // We get the corresponding account from the database (if it exists)
                    $account = $this->em->getRepository(Account::class)->findOneBy([
                        'username' => $data["username"],
                        'password' => $data["password"],
                    ]);

                    // If the credentials are invalid : ERROR
                    if($account == null)
                    {
                        $errorMessageLogin = "Invalid credentials, please try again";
                    }
                    // The credentials are valid : proceed !
                    else
                    {
                        // We set some data
                        $session->set('userID', $account->getId());
                        $session->set('isWebsiteAdmin', $account->GetIsWebsiteAdmin());

                        // redirect the user to the mainPage
                        return $this->redirectToRoute('homepage');
                    }
                }
                

                // If reached : something went wrong with the Login
                return $this->render('accounts/connection.html.twig', [
                    'errorMessageLogin' => $errorMessageLogin,
                    'activeLogin' => true,
                ]);
            }
            elseif( $this->isCsrfTokenValid('account_signin', $data['token']) )
            {
                // We check if the form's entries are valid
                // Do more verifications if needed :)
                $isValid = (isset($data["username"]) && strlen($data["username"]) <= 20 && isset($data["email"]) && isset($data["password"]));
                
                // If the data entered by the user are invalid : ERROR
                if (!$isValid)
                {
                    $errorMessageSignin = "Please verify your inputs";
                }
                // The data are valid : proceed !
                else
                {
                    // We check if the username is not already taken
                    $takenUsername = $this->em->getRepository(Account::class)->findOneBy(['username' => $data["username"]]);

                    // If the credentials are invalid : ERROR
                    if($takenUsername != null)
                    {
                        $errorMessageSignin = "The Username is already taken !";
                    }
                    // The credentials are valid : proceed !
                    else
                    {
                        // We check if the username is not already taken
                        $takenEmail = $this->em->getRepository(Account::class)->findOneBy(['email' => $data["email"]]);
    
                        // If the credentials are invalid : ERROR
                        if($takenEmail != null)
                        {
                            $errorMessageSignin = "The Email is already taken !";
                        }
                        else
                        {
                            // we define a Profile instance
                            $newAccount = new Account;
                            $newAccount->setUsername($data["username"]);
                            $newAccount->setEmail($data["email"]);
                            $newAccount->setPassword($data["password"]);

                            // We push it into the database
                            $this->em->persist($newAccount);
                            $this->em->flush();

                            // We set some data
                            $session->set('userID', $newAccount->getId());
                            $session->set('isWebsiteAdmin', false);

                            // redirect the user to the mainPage
                            return $this->redirectToRoute('homepage');
                        }
                    }

                    // If reached : something went wrong with the Signin
                    return $this->render('accounts/connection.html.twig', [
                        'errorMessageSignin' => $errorMessageSignin,
                        'activeSignin' => true,
                        ]);
                }
            }
            else
            {
                $errorMessage = "hmm, this unusual... have you ever heard of CSRF ?";
            }
        }


        // The user just arrived on the page :
        // => We display the forms (no initial error message)
        return $this->render('accounts/connection.html.twig');
    }



    
    public function login($data): Response
    {
        return $this->redirectToRoute('homepage'); 
    }
}
