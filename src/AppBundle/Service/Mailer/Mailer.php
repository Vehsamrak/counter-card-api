<?php

namespace AppBundle\Service\Mailer;

use AppBundle\Entity\Card;

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

    /**
     * @param Card $card
     * @param string $email
     */
    public function sendCardByMail(Card $card): void
    {
        $creator = $card->getCreator();
        $flatNumber = $creator->getFlatNumber();
        $creatorEmail = $creator->getEmail();
        $message = \Swift_Message::newInstance();
        $message->setSubject(sprintf('Показания счетчиков квартиры №%d', $flatNumber));
        $message->setFrom('developesque@gmail.com'); // TODO[petr]: get from configuration parameters
        $message->setBody(
            $this->twig->render(
                'AppBundle:Mail:counterCard.html.twig',
                [
                    'card'       => $card,
                    'flatNumber' => $flatNumber,
                ]
            ),
            'text/html'
        );

        if ($creator->isConfirmed()) {
            // TODO[petr]: move company email to configuration parameters
            $message->setTo('atlanta64k9@yandex.ru');
            $message->setBcc($creatorEmail);
        } else {
            $message->setTo('developesque@gmail.com');
        }

        $this->swiftMailer->send($message);
    }
}
