<?php

namespace App\Controller;

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
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $allQuestions = $em->getRepository('App:Question')->findAll();

        $questions = $paginator->paginate(
            $allQuestions,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',10)
        );

        return $this->render('default/index.html.twig', [
            'questions' => $questions,
        ]);
    }
}
