<?php

namespace AppBundle\Service\IdGenerator;

use Ramsey\Uuid\Uuid;

/**
 * @author Vehsamrak
 */
class IdGenerator
{
    public function generateUuid(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function generateString(int $length = 8): string
    {
        $chunksNumber = ceil($length / 4);

        $hashString = '';

        while ($chunksNumber > 0) {
            $chunksNumber--;
            $hashString = sprintf('%s%04x', $hashString, mt_rand(0, 0xffff));
        }

        return substr($hashString, 0, $length);
    }
}
