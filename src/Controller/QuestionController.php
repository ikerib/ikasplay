<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\QuizzDet;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/question")
 */
class QuestionController extends AbstractController {

    /**
     * @Route("/", name="question_index", methods={"GET"})
     * @param Request            $request
     * @param QuestionRepository $questionRepository
     *
     * @param PaginatorInterface $paginator
     *
     * @return Response
     */
    public function index(Request $request, QuestionRepository $questionRepository, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $questionRepository
            ->createQueryBuilder('q')
            ->orderBy('q.id', 'DESC')
            ;

        if ($request->query->getAlnum('filter')){
            $queryBuilder->where('q.name LIKE :name')->setParameter('name', '%'.$request->query->getAlnum('filter').'%');
        }


        $query = $queryBuilder->getQuery();

        $questions = $paginator->paginate($query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render(
            'question/index.html.twig',
            [
                'questions' => $questions,
            ]
        );
    }

    /**
     * @Route("/new", name="question_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $question = new Question();
        $form     = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('question_index');
        }

        return $this->render(
            'question/new.html.twig',
            [
                'question' => $question,
                'form'     => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="question_show", methods={"GET"})
     * @param Question $question
     *
     * @return Response
     */
    public function show(Question $question): Response
    {
        /** @var EntityManager $em */
        $em              = $this->getDoctrine()->getManager();
        $quizzTotal      = $em->getRepository(QuizzDet::class)->getAllQuizCount();
        $quizzCorrect    = $em->getRepository(QuizzDet::class)->getCorrectAnswersCount();
        $quizzInCorrect  = $em->getRepository(QuizzDet::class)->getIncorrectAnswersCount();
        $quizzUnAnswered = $em->getRepository(QuizzDet::class)->getUnansweredCount();

        return $this->render(
            'question/show.html.twig',
            [
                'question'        => $question,
                'quizzTotal'      => $quizzTotal,
                'quizzCorrect'    => $quizzCorrect,
                'quizzInCorrect'  => $quizzInCorrect,
                'quizzUnAnswered' => $quizzUnAnswered,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="question_edit", methods={"GET","POST"})
     * @param Request  $request
     * @param Question $question
     *
     * @return Response
     */
    public function edit(Request $request, Question $question): Response
    {
        $em              = $this->getDoctrine()->getManager();
        $originalAnswers = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($question->getAnswers() as $answer)
        {
            $originalAnswers->add($answer);
        }

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var Answer $ans */
            foreach ($originalAnswers as $ans)
            {
                if (false === $question->getAnswers()->contains($ans))
                {
//                    $ans->getQuestion()->removeAnswer($ans);
                    $em->remove($ans);
                }
            }


            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute(
                'question_index',
                [
                    'id' => $question->getId(),
                ]
            );
        }

        return $this->render(
            'question/edit.html.twig',
            [
                'question' => $question,
                'form'     => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="question_delete", methods={"DELETE"})
     * @param Request  $request
     * @param Question $question
     *
     * @return Response
     */
    public function delete(Request $request, Question $question): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token')))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('question_index');
    }
}
