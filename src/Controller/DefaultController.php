<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Entity\QuizzDet;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="default")
     * @param Request            $request
     * @param PaginatorInterface $paginator
     *
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {

        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/quizz/new", name="quizz_new")
     *
     * @param Request $request
     *
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function newQuizz(Request $request): Response
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $allQuestions = $em->getRepository('App:Question')->findAll();
        $allQuizz = $em->getRepository('App:Quizz')->findAll();
        foreach ($allQuizz as $quizz) {
            $em->remove($quizz);
        }
        $em->flush();

        $quizz = new Quizz();
        $quizz->setName('Quizz');
        $quizz->setCreated(new \DateTime());
        foreach ($allQuestions as $question) {
            /** @var QuizzDet $qd */
            $qd = new QuizzDet();
            $qd->setQuizz($quizz);
            $qd->setQuestion($question);
            $qd->setResult(0);
            $em->persist($qd);
        }
        $em->flush();

        return $this->redirectToRoute('quizz_index');


    }



    /**
     * @Route("/quizz", name="quizz_index")
     * @param Request            $request
     * @param PaginatorInterface $paginator
     *
     * @return Response
     */
    public function quizz(Request $request, PaginatorInterface $paginator): Response
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $allQuestions = $em->getRepository('App:Question')->findAll();

        $questions = $paginator->paginate(
            $allQuestions,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',1)
        );



        return $this->render('default/quizz_index.html.twig', [
            'questions' => $questions,
        ]);
    }
}
