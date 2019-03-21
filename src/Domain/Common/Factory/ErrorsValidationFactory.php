<?php

namespace App\Domain\Common\Factory;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use App\Domain\Common\Exceptions\ValidatorException;

class ErrorsValidationFactory
{
    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     * @throws ValidatorException
     */
    public static function buildError(ConstraintViolationListInterface $constraintViolationList)
    {
        if (count($constraintViolationList) > 0) {
            $errors = [];
            /** @var ConstraintViolationInterface $constraint */
            foreach ($constraintViolationList as $constraint) {
                $errors[$constraint->getPropertyPath()][] = $constraint->getMessage();
            }

            throw new ValidatorException(
                Response::HTTP_BAD_REQUEST,
                $errors
            );
        }
    }
}
