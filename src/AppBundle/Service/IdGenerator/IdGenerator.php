<?php

namespace AppBundle\Service\IdGenerator;

use Ramsey\Uuid\Uuid;

/**
 * @author Vehsamrak
 */
class IdGenerator
{

    public function generateRandomId(): string
    {
        return Uuid::uuid4()->toString();
    }
}
