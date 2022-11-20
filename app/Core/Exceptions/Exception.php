<?php

namespace App\Core\Exceptions;

abstract class Exception extends \Exception
{
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return "Error {$this->code}: {$this->message}";
    }

    /**
     * Return error message to the client in the json format
     *
     * @param bool $json
     */
    public function print($json = true)
    {
        http_response_code($this->code);

        if ($json)
        {
            header("Content-Type: application/json");

            echo json_encode([
                'code' => $this->getCode(),
                'message' => $this->getMessage()
            ]);
        }
        else
        {
            echo $this->__toString();
        }
    }
}