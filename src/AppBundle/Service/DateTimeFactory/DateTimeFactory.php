<?php

namespace AppBundle\Service\DateTimeFactory;

/**
 * @author Vehsamrak
 */
class DateTimeFactory
{

    public function getCurrentDateAndTime(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
