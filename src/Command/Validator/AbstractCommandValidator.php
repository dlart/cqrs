<?php

/*
 * This file is part of CQRS package.
 *
 * (c) Denis Lityagin <denis.lityagin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled with this
 * source code in the file LICENSE.
 */

namespace Dlart\CQRS\Command\Validator;

use Assert\Assertion;
use Dlart\CQRS\Command\CommandInterface as Command;
use Dlart\CQRS\Command\Validator\CommandValidatorInterface as CommandValidator;
use Verraes\ClassFunctions\ClassFunctions;

/**
 * AbstractCommandValidator.
 *
 * @author Denis Lityagin <denis.lityagin@gmail.com>
 */
abstract class AbstractCommandValidator implements CommandValidator
{
    /**
     * @param Command $command
     */
    public function handle(Command $command): void
    {
        $handleMethodName = 'handle'.ClassFunctions::short($command);

        Assertion::methodExists(
            $handleMethodName,
            $this
        );

        $this->$handleMethodName($command);
    }
}
