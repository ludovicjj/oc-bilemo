<?php

namespace App\Domain\Common\Exceptions;

use Throwable;

class ValidatorException extends \Exception
{
    /** @var int  */
    private $statusCode;

    /** @var array  */
    private $errors;

    /**
     * ValidatorException constructor.
     *
     * @param int $statusCode
     * @param array $errors
     */
    public function __construct(
        int $statusCode,
        array $errors
    ) {
        $this->statusCode = $statusCode;
        $this->errors = $errors;
        parent::__construct();
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
