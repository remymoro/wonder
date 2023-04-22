<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/user/{id}', name:'user')]
    #[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
    public function profileUser(User $user)
    {


        $currentUser =$this->getUser();
        if($currentUser == $user) {

            return $this->redirectToRoute('current_user');

        }


        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);


    }




    #[Route('/user', name: 'current_user')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function currentUserProfile(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $userPasswordHasher
    ): Response {


        /** @var \App\Entity\User $user */


        $user =$this->getUser();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->remove('password');
        $userForm->add('newPassword', PasswordType::class, ['label'=>"Nouveau mot de passe", 'required'=>false]);
        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) {
            $newPassword = $user->getNewPassword();

            if($newPassword) {
                $hash = $userPasswordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hash);
            }

            $em->flush();
            $this->addFlash('success', 'Modifications sauvegardées !');
        }


        return $this->render('user/index.html.twig', [
            'form' => $userForm->createView()
        ]);
    }





}
