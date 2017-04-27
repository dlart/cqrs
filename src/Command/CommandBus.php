<?php

/*
 * This file is part of CQRS package.
 *
 * (c) Denis Lityagin <denis.lityagin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled with this
 * source code in the file LICENSE.
 */

namespace Dlart\CQRS\Command;

use Assert\Assertion;
use Dlart\CQRS\Command\CommandInterface as Command;
use Dlart\CQRS\Command\Exception\CommandRejectedException;
use Dlart\CQRS\Command\Handler\CommandHandlerInterface as Handler;
use Dlart\CQRS\Command\Validator\CommandValidatorInterface as Validator;

/**
 * CommandBus.
 *
 * @author Denis Lityagin <denis.lityagin@gmail.com>
 */
class CommandBus
{
    /**
     * @var Handler[]
     */
    private $handlers = [];

    /**
     * @var Validator[]
     */
    private $validators = [];

    /**
     * @param Command $command
     */
    public function handle(Command $command): void
    {
        $this->assertThatHandlerForCommandIsRegistered($command);

        if ($this->isValidatorForCommandRegistered($command)) {
            try {
                $this->getValidatorForCommand($command)->handle($command);
            } catch (CommandRejectedException $commandRejectedException) {
                return;
            }
        }

        $this->getHandlerForCommand($command)->handle($command);
    }

    /**
     * @param Handler $handler
     * @param string  $fullyQualifiedCommandClassName
     */
    public function registerHandler(
        Handler $handler,
        string $fullyQualifiedCommandClassName
    ): void {
        Assertion::notEmpty($fullyQualifiedCommandClassName);

        $this->handlers[$fullyQualifiedCommandClassName] = $handler;
    }

    /**
     * @param Validator $validator
     * @param string    $fullyQualifiedCommandClassName
     */
    public function registerValidator(
        Validator $validator,
        string $fullyQualifiedCommandClassName
    ): void {
        Assertion::notEmpty($fullyQualifiedCommandClassName);

        $this->validators[$fullyQualifiedCommandClassName] = $validator;
    }

    /**
     * @param Command $command
     */
    private function assertThatHandlerForCommandIsRegistered(
        Command $command
    ): void {
        Assertion::keyIsset(
            $this->handlers,
            get_class($command)
        );
    }

    /**
     * @param Command $command
     *
     * @return null|Handler
     */
    private function getHandlerForCommand(Command $command): ?Handler
    {
        return $this->handlers[get_class($command)] ?? null;
    }

    /**
     * @param Command $command
     *
     * @return null|Validator
     */
    private function getValidatorForCommand(Command $command): ?Validator
    {
        return $this->validators[get_class($command)] ?? null;
    }

    /**
     * @param Command $command
     *
     * @return bool
     */
    private function isValidatorForCommandRegistered(Command $command): bool
    {
        return isset($this->validators[get_class($command)]);
    }
}
