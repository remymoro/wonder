<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Question;
use App\Form\CommentType;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{
    #[Route('/question/ask', name: 'question_form')]
    #[IsGranted('ROLE_USER')]
    public function index(
        Request $request,
        EntityManagerInterface $em
    ): Response {

        $user= $this->getUser();
        $question = new Question();
        $formQuestion = $this->createForm(QuestionType::class, $question);
        $formQuestion->handleRequest($request);

        if($formQuestion->isSubmitted() && $formQuestion->isValid()) {
            $question->setRating(0);
            $question->setAuthor($user);
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


    #[Route('/question/{id}', name: 'question_show')]
    public function show(
        Request $request,
        Question $question,
        EntityManagerInterface $em
    ): Response {

        $options = ['question'=>$question];

        $user = $this->getUser();
        if($user) {
            $comment = new Comment();
            $commentForm = $this->createForm(CommentType::class, $comment);
            $commentForm->handleRequest($request);

            if($commentForm->isSubmitted() && $commentForm->isValid()) {
                $comment->setRating(0);
                $comment->setQuestion($question);
                $comment->setAuthor($user);
                $question->setNbrOfResponse($question->getNbrOfResponse() + 1);
                $em->persist($comment);
                $em->flush();
                $this->addFlash('success', 'Votre réponse à bien été ajouté');
                return $this->redirect($request->getUri());
            }
            $options['form'] = $commentForm->createView();
        }


        return $this->render('question/show.html.twig', $options);
    }




    #[Route('/question/rating/{id}/{score}', name:'question_rating')]
    public function questionRating(
        Question $question,
        EntityManagerInterface $em,
        int $score,
        Request $request
    ) {
        $question->setRating($question->getRating() + $score);
        $em->flush();
        $referer = $request->server->get('HTTP_REFERER');
        return $referer ? $this->redirect($referer) : $this->redirectToRoute('home');

    }



    #[Route('/comment/rating/{id}/{score}', name:'comment_rating')]
    public function commentRating(
        Comment $comment,
        EntityManagerInterface $em,
        int $score,
        Request $request
    ) {

        $comment->setRating($comment->getRating() + $score);
        $em->flush();
        $referer = $request->server->get('HTTP_REFERER');
        return  $referer ? $this->redirect($referer) : $this->redirectToRoute('home');

    }







}
