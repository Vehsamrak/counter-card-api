<?php

namespace AppBundle\Controller;

use AppBundle\Controller\Infrastructure\AbstractRestController;
use AppBundle\Entity\Card;
use AppBundle\Entity\User;
use AppBundle\Response\MandatoryParameterMissedResponse;
use AppBundle\Response\NotFoundResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_USER')")
 */
class CardController extends AbstractRestController
{

    /**
     * @Route("/card", name="api_create_card")
     * @Method("POST")
     * @return MandatoryParameterMissedResponse|JsonResponse
     */
    public function createAction(Request $request)
    {
        $waterHot = $this->formatFloatNumber($request->get('waterHot'));
        $waterCold = $this->formatFloatNumber($request->get('waterCold'));
        $electricityDay = $this->formatFloatNumber($request->get('electricityDay'));
        $electricityNight = $this->formatFloatNumber($request->get('electricityNight'));

        if ($waterHot && $waterCold && $electricityDay && $electricityNight) {
            $creator = $this->getUser();
            $card = new Card($creator, $waterHot, $waterCold, $electricityDay, $electricityNight);
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
    public function lastAction()
    {
        $cardRepository = $this->get('counter_card.card_repository');
        $card = $cardRepository->findLastForUser($this->getUser()->getId());

        if (!$card) {
        	return new NotFoundResponse();
        }

        return $this->respond($card);
    }

    private function sendCardByMail(Card $card): void
    {
        /** @var User $user */
        $user = $this->getUser();
        $flatNumber = $user->getFlatNumber();
        $userEmail = $user->getEmail();

        $message = \Swift_Message::newInstance()
                                 ->setSubject(sprintf('Показания счетчиков квартиры №%d', $flatNumber))
            // TODO[petr]: move to configuration parameters
                                 ->setFrom('developesque@gmail.com')
            // TODO[petr]: move to configuration parameters
                                 ->setTo('atlanta64k9@yandex.ru')
                                 ->setBcc($userEmail)
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

    /**
     * @param string|int|float $rawFloatNumber
     * @return float
     */
    private function formatFloatNumber($rawFloatNumber): float
    {
        return floatval(str_replace(',', '.', $rawFloatNumber));
    }
}
