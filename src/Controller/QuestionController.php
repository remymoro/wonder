<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/question', name: 'question_')]
class QuestionController extends AbstractController
{
    #[Route('/ask', name: 'form')]
    public function index(
        Request $request,
        EntityManagerInterface $em
    ): Response {


        $question = new Question();
        $formQuestion = $this->createForm(QuestionType::class, $question);
        $formQuestion->handleRequest($request);

        if($formQuestion->isSubmitted() && $formQuestion->isValid()) {
            $question->setRating(0);
            $question->setNbrOfResponse(0);
            $em->persist($question);
            $em->flush();
            $this->addFlash('success', 'Votre question a été ajoutée');
            return  $this->redirectToRoute('home');
        }

        return $this->render('question/index.html.twig', [
            'form' => $formQuestion->createView(),
        ]);
    }


    #[Route('/{id}', name: 'show')]
    public function show(Request $request, Question $question): Response
    {



        return $this->render('question/show.html.twig', [
          'question' => $question,
        ]);
    }



}
