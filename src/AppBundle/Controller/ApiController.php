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

            $this->sendCardByMail($card);

            $response = new JsonResponse($card->getId());
        } else {
            $response = new MandatoryParameterMissedResponse();
        }

        return $response;
    }

    /**
     * @Route("/card/last", name="api_last_card")
     * @Method("GET")
     * @return JsonResponse
     */
    public function lastAction(Request $request)
    {
        $cardRepository = $this->get('counter_card.card_repository');
        $card = $cardRepository->findLast();

        $cardData = [
            'id'         => $card->getId(),
            'created_at' => $card->getCreatedAt()->format('Y-m-d H:i:s'),
        ];

        return new JsonResponse($cardData);
    }

    private function sendCardByMail(Card $card): void
    {
        // TODO: change to actual flat number from User
        $flatNumber = 1;
        $message = \Swift_Message::newInstance()
                                 ->setSubject(sprintf('Показания счетчиков квартиры №%d', $flatNumber))
                                 ->setFrom('developesque@gmail.com')
            // TODO: change to actual email of directing company
                                 ->setTo('sirsmonkl@gmail.com')
                                 ->setBody(
                                     $this->renderView(
                                         'AppBundle:Mail:counterCard.html.twig',
                                         [
                                             'card'       => $card,
                                             'flatNumber' => $flatNumber,
                                         ]
                                     ),
                                     'text/html'
                                 );

        $this->get('mailer')->send($message);
    }
}
