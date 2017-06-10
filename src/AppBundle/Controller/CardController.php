<?php

namespace AppBundle\Controller;

use AppBundle\Controller\Infrastructure\AbstractRestController;
use AppBundle\Entity\Card;
use AppBundle\Entity\User;
use AppBundle\Response\CreatedResponse;
use AppBundle\Response\MandatoryParameterMissedResponse;
use AppBundle\Response\NotAllowedResponse;
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
            /** @var User $creator */
            $creator = $this->getUser();
            $cardRepository = $this->get('counter_card.card_repository');

            $lastCard = $cardRepository->findLastForUser($creator->getId());
            $ago20Days = new \DateTimeImmutable('-20 days');

            if ($lastCard && $lastCard->getCreatedAt() > $ago20Days) {
                $response = new NotAllowedResponse();
            } else {
                $card = new Card($creator, $waterHot, $waterCold, $electricityDay, $electricityNight);
                $cardRepository->persist($card);
                $cardRepository->flush();

                $mailer = $this->get('mailer');
                $mailer->sendCardByMail($card, $this->getUser());

                $response = new CreatedResponse($card->getId());
            }
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

    /**
     * @param string|int|float $rawFloatNumber
     * @return float
     */
    private function formatFloatNumber($rawFloatNumber): float
    {
        return floatval(str_replace(',', '.', $rawFloatNumber));
    }
}
