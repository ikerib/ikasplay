<?php

namespace App\Controller;

use App\Entity\QuizzDet;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends AbstractFOSRestController
{

    /**
     * @Route("/ping", name="healthcheck", methods={"GET"})
     */
    public function getAction(): JsonResponse
    {
        return new JsonResponse('Pong');
    }


    /**
     * @Rest\Put("/quizzdet/{id}", name="put_quizzdet", methods={"PUT"}, requirements={"id"="\d+"})
     * @param Request $request
     * @param string  $id
     *
     * @return JsonResponse
     */
    public function putAction(Request $request, string $id)
    {
        $em = $this->getDoctrine()->getManager();
        $quizzdet = $em->getRepository(QuizzDet::class)->find($id);

        $result = $request->get('result');
        $quizzdet->setResult($result);
        $em->persist($quizzdet);

        $em->flush();
        $view = $this->view($quizzdet, 200);
//        return new JsonResponse('Record saved', 200);
//        return new View('Record saved',200);
//        return $this->handleView($view);
        return new JsonResponse("OK");
    }
}
