<?php

namespace App\Controller;

use App\Entity\Familly;
use App\Form\FamillyType;
use App\Repository\FamillyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/familly")
 */
class FamillyController extends AbstractController
{

    /**
     * @Route("/", name="familly_index", methods={"GET"})
     * @param FamillyRepository $famillyRepository
     *
     * @return Response
     */
    public function index(FamillyRepository $famillyRepository): Response
    {
        return $this->render('familly/index.html.twig', [
            'famillies' => $famillyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="familly_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $familly = new Familly();
        $form = $this->createForm(FamillyType::class, $familly);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($familly);
            $entityManager->flush();

            return $this->redirectToRoute('familly_index');
        }

        return $this->render('familly/new.html.twig', [
            'familly' => $familly,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="familly_show", methods={"GET"})
     * @param Familly $familly
     *
     * @return Response
     */
    public function show(Familly $familly): Response
    {
        return $this->render('familly/show.html.twig', [
            'familly' => $familly,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="familly_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Familly $familly
     *
     * @return Response
     */
    public function edit(Request $request, Familly $familly): Response
    {
        $form = $this->createForm(FamillyType::class, $familly);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('familly_index', [
                'id' => $familly->getId(),
            ]);
        }

        return $this->render('familly/edit.html.twig', [
            'familly' => $familly,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="familly_delete", methods={"DELETE"})
     * @param Request $request
     * @param Familly $familly
     *
     * @return Response
     */
    public function delete(Request $request, Familly $familly): Response
    {
        if ($this->isCsrfTokenValid('delete'.$familly->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($familly);
            $entityManager->flush();
        }

        return $this->redirectToRoute('familly_index');
    }
}
