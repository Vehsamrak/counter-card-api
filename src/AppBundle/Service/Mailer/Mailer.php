<?php

namespace AppBundle\Service\Mailer;

use AppBundle\Entity\Card;
use AppBundle\Entity\User;

/**
 * @author Vehsamrak
 */
class Mailer
{

    /** @var \Swift_Mailer */
    private $swiftMailer;
    /** @var \Twig_Environment */
    private $twig;

    public function __construct(\Swift_Mailer $swiftMailer, \Twig_Environment $twig)
    {
        $this->swiftMailer = $swiftMailer;
        $this->twig = $twig;
    }

    public function sendCardByMail(Card $card, User $user): void
    {
        $flatNumber = $user->getFlatNumber();
        $userEmail = $user->getEmail();

        $message = \Swift_Message::newInstance()
                                 ->setSubject(sprintf('Показания счетчиков квартиры №%d', $flatNumber))
            // TODO[petr]: move to configuration parameters
                                 ->setFrom('developesque@gmail.com')
            // TODO[petr]: move to configuration parameters
                                 ->setTo('smonkl@bk.ru')
//                                 ->setTo('atlanta64k9@yandex.ru')
                                 ->setBcc($userEmail)
                                 ->setBody(
                                     $this->twig->render(
                                         'AppBundle:Mail:counterCard.html.twig',
                                         [
                                             'card'       => $card,
                                             'flatNumber' => $flatNumber,
                                         ]
                                     ),
                                     'text/html'
                                 );

        $this->swiftMailer->send($message);
    }
}
