<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user); 
        $form->handleRequest($request);
        $notification = null;

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $search_email = $doctrine->getRepository(User::class)->findOneByEmail($user->getEmail());
            if (!$search_email) {
                $user->setPassword($encoder->hashPassword($user, $user->getPassword()));
                $user->setRegistrationDate(DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
                $user->setRoles(['ROLE_USER']);
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', "Votre inscription s'est correctement déroulée, vous pouvez dès a present vous connecter à votre compte.");
                return $this->redirectToRoute('login');
            }else{
                $notification = "L'émail que vous avez renseigner existe déjà.";
            } 
        }
        return $this->render('register/index.html.twig', [
            'form' => $form->createView(), 
            'notification'=> $notification
        ]);
    }
}
