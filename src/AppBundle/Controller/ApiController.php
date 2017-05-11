<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Card;
use AppBundle\Response\MandatoryParameterMissedResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api")
 */
class ApiController extends Controller
{

    /**
     * @Route("/", name="api_index")
     */
    public function indexAction()
    {
        return new JsonResponse();
    }

    /**
     * @Route("/card", name="api_create_card")
     * @Method("POST")
     * @return MandatoryParameterMissedResponse|JsonResponse
     */
    public function createAction(Request $request)
    {
        $requestContentsJson = $request->getContent();
        $requestContents = json_decode($requestContentsJson, true);

        $waterHot = $requestContents['waterHot'];
        $waterCold = $requestContents['waterCold'];
        $electricityDay = $requestContents['electricityDay'];
        $electricityNight = $requestContents['electricityNight'];

        if ($waterHot && $waterCold && $electricityDay && $electricityNight) {
            $card = new Card($waterHot, $waterCold, $electricityDay, $electricityNight);
            $cardRepository = $this->get('counter_card.card_repository');
            $cardRepository->persist($card);
            $cardRepository->flush();

            $response = new JsonResponse($card->getId());
        } else {
            $response = new MandatoryParameterMissedResponse();
        }

        return $response;
    }
}
