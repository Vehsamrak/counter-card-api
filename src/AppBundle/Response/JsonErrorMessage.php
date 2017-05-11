<?php

namespace AppBundle\Response;

/**
 * @author Vehsamrak
 */
class JsonErrorMessage
{

    /** @var string */
    public $error;

    public function __construct(string $error)
    {
        $this->error = $error;
    }
}
