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
        $this->assertThatHandleMethodForCommandIsExist($command);

        $validateMethodName = $this->getHandleMethodNameForCommand($command);

        $this->$validateMethodName($command);
    }

    /**
     * @param Command $command
     */
    private function assertThatHandleMethodForCommandIsExist(
        Command $command
    ): void {
        Assertion::methodExists(
            $this->getHandleMethodNameForCommand($command),
            $this
        );
    }

    /**
     * @param Command $command
     *
     * @return string
     */
    private function getHandleMethodNameForCommand(Command $command): string
    {
        return 'handle'.$this->getNameOfCommand($command);
    }

    /**
     * @param Command $command
     *
     * @return string
     */
    private function getNameOfCommand(Command $command): string
    {
        $fullyQualifiedCommandClassParts = explode('\\', get_class($command));

        return end($fullyQualifiedCommandClassParts);
    }
}
