<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Quizz;
use App\Entity\QuizzDet;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController {

    /**
     * @Route("/", name="default")
     * @param Request            $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {

        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/quizz/new", name="quizz_new")
     *
     * @param Request $request
     *
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function newQuizz(Request $request): Response
    {
        /** @var EntityManager $em */
        $em           = $this->getDoctrine()->getManager();
        $allQuestions = $em->getRepository(Question::class)->findAll();
        $allQuizz     = $em->getRepository(Quizz::class)->findAll();
        foreach ($allQuizz as $quizz)
        {
            $em->remove($quizz);
        }
        $em->flush();

        $quizz = new Quizz();
        $quizz->setName('Quizz');
        $quizz->setCreated(new DateTime());
        foreach ($allQuestions as $question)
        {
            /** @var QuizzDet $qd */
            $qd = new QuizzDet();
            $qd->setQuizz($quizz);
            $qd->setQuestion($question);
            $em->persist($qd);
        }
        $em->flush();

        return $this->redirectToRoute('quizz_index');


    }


    /**
     * @Route("/quizz", name="quizz_index")
     *
     * @param Request $request
     *
     * @return Response
     * @throws EntityNotFoundException
     */
    public function quizz(Request $request): Response
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $direction  = $request->query->get('direction');
        $miid       = $request->query->get('miid');
        $repaso     = $request->query->get('repaso') === '1';
        $isLehena   = false;
        $isAzkena   = false;
        $isFirst    = false;
        $isLast     = false;

        if ($direction === null) {
            if (!$repaso) {
                $allQuizz = $em->getRepository(QuizzDet::class)->findFirst(null);
            } else {
                $allQuizz = $em->getRepository(QuizzDet::class)->findFirst(0);
            }
            $isLehena = true;
            $isAzkena = count($allQuizz) === 1;
        } elseif ($direction==='next') {
            $allQuizz = $this->quizznext($miid, $repaso);
            $isLehena = false;
            $isAzkena = count($allQuizz) === 1;
        } else {
            $allQuizz = $this->quizzprevious($miid, $repaso);
            $isLehena = count($allQuizz)===1;
            $isAzkena = false;
        }


        if (!$allQuizz)
        {
            throw new EntityNotFoundException('No quizz found');
        }
        $isFirst = $isLehena === true;
        $isLast  = $isAzkena === true;

        $quizzTotal = $em->getRepository(QuizzDet::class)->getAllQuizCount();
        $quizzCorrect = $em->getRepository(QuizzDet::class)->getCorrectAnswersCount();
        $quizzInCorrect = $em->getRepository(QuizzDet::class)->getIncorrectAnswersCount();
        $quizzUnAnswered = $em->getRepository(QuizzDet::class)->getUnansweredCount();

        return $this->render(
            'default/quizz_index.html.twig',
            [
                'quizz'   => $allQuizz[ 0 ],
                'isFirst' => $isFirst,
                'isLast'  => $isLast,
                'repaso'  => $repaso,
                'quizzTotal'    => $quizzTotal,
                'quizzCorrect' => $quizzCorrect,
                'quizzInCorrect' => $quizzInCorrect,
                'quizzUnAnswered' => $quizzUnAnswered
            ]
        );
    }

    /**
     * @param $id
     * @param $repaso
     *
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function quizznext($id, $repaso)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $allQuizz = $em->getRepository(QuizzDet::class)->findNext($id,$repaso);

        if (!$allQuizz)
        {
            throw new EntityNotFoundException('No quizz found');
        }

        return $allQuizz;
    }

    /**
     *
     * @param $id
     * @param $repaso
     *
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function quizzprevious($id, $repaso)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $allQuizz = $em->getRepository(QuizzDet::class)->findPrevious($id, $repaso);

        if (!$allQuizz)
        {
            throw new EntityNotFoundException('No quizz found');
        }

        return $allQuizz;
    }


}
