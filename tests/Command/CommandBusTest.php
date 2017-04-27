<?php

/*
 * This file is part of CQRS package.
 *
 * (c) Denis Lityagin <denis.lityagin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled with this
 * source code in the file LICENSE.
 */

namespace Dlart\CQRS\Tests\Command;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Dlart\CQRS\Command\CommandBus;
use Dlart\CQRS\Command\CommandInterface as Command;
use Dlart\CQRS\Command\Exception\CommandRejectedException;
use Dlart\CQRS\Command\Handler\CommandHandlerInterface as CommandHandler;
use Dlart\CQRS\Command\Validator\CommandValidatorInterface as CommandValidator;
use PHPUnit\Framework\TestCase;

/**
 * CommandBusTest.
 *
 * @author Denis Lityagin <denis.lityagin@gmail.com>
 */
class CommandBusTest extends TestCase
{
    public function testThatCommandCanBeRejected(): void
    {
        $command = self::getMockBuilder(Command::class)
            ->setMockClassName('FooCommand')
            ->getMockForAbstractClass()
        ;

        $commandHandler = self::getMockBuilder(CommandHandler::class)
            ->setMethods(['handle'])
            ->getMockForAbstractClass()
        ;

        $commandHandler
            ->expects(self::never())
            ->method('handle')
            ->with($command)
        ;

        $commandBus = new CommandBus();

        $commandBus->registerHandler($commandHandler, get_class($command));

        $validator = self::getMockBuilder(CommandValidator::class)
            ->setMethods(['handle'])
            ->getMockForAbstractClass()
        ;

        $validator
            ->expects(self::once())
            ->method('handle')
            ->with($command)
            ->willThrowException(new CommandRejectedException())
        ;

        $commandBus->registerValidator($validator, get_class($command));

        $commandBus->handle($command);
    }

    public function testThatCommandMustBeProvidedOnHandlerRegistering(): void
    {
        $commandHandler = self::getMockForAbstractClass(CommandHandler::class);

        $commandBus = new CommandBus();

        self::expectException(AssertionFailedException::class);
        self::expectExceptionCode(Assertion::VALUE_EMPTY);

        $commandBus->registerHandler($commandHandler, '');
    }

    public function testThatCommandMustBeProvidedOnValidatorRegistering(): void
    {
        $commandValidator = self::getMockForAbstractClass(
            CommandValidator::class
        );

        $commandBus = new CommandBus();

        self::expectException(AssertionFailedException::class);
        self::expectExceptionCode(Assertion::VALUE_EMPTY);

        $commandBus->registerValidator($commandValidator, '');
    }

    public function testThatRegisteredHandlerForCommandIsCalled(): void
    {
        $command = self::getMockBuilder(Command::class)
            ->setMockClassName('FooCommand')
            ->getMockForAbstractClass()
        ;

        $commandHandler = self::getMockBuilder(CommandHandler::class)
            ->setMethods(['handle'])
            ->getMockForAbstractClass()
        ;

        $commandHandler->expects(self::once())
            ->method('handle')
            ->with($command)
        ;

        $commandBus = new CommandBus();

        $commandBus->registerHandler($commandHandler, get_class($command));

        $commandBus->handle($command);
    }

    public function testThatRegisteredValidatorForCommandIsCalled(): void
    {
        $command = self::getMockBuilder(Command::class)
            ->setMockClassName('FooCommand')
            ->getMockForAbstractClass()
        ;

        $commandHandler = self::getMockBuilder(CommandHandler::class)
            ->setMethods(['handle'])
            ->getMockForAbstractClass()
        ;

        $commandHandler
            ->expects(self::once())
            ->method('handle')
            ->with($command)
        ;

        $commandBus = new CommandBus();

        $commandBus->registerHandler($commandHandler, get_class($command));

        $validator = self::getMockBuilder(CommandValidator::class)
            ->setMethods(['handle'])
            ->getMockForAbstractClass()
        ;

        $validator
            ->expects(self::once())
            ->method('handle')
            ->with($command)
        ;

        $commandBus->registerValidator($validator, get_class($command));

        $commandBus->handle($command);
    }
}
