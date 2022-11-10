<?php

namespace App\Domain\Exception;

class ValidationException extends \Exception
{
    private array $errorList;

    public function __construct(array $errorList, $message = "validation_exception")
    {
        foreach ($errorList as $key => $error) {
            if ($message == "validation_exception" && !empty($error))
            $message = $error[0];
            break;
        }

        parent::__construct($message, $cod = 0, $previous = null);

        $this->errorList = $errorList;
    }

    public function getErrorList()
    {
        return $this->errorList;
    }
}
