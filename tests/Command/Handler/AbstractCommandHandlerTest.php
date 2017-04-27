<?php

/*
 * This file is part of CQRS package.
 *
 * (c) Denis Lityagin <denis.lityagin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled with this
 * source code in the file LICENSE.
 */

namespace Dlart\CQRS\Tests\Command\Handler;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use Dlart\CQRS\Command\CommandInterface as Command;
use Dlart\CQRS\Command\Handler\AbstractCommandHandler as CommandHandler;
use PHPUnit\Framework\TestCase;

/**
 * AbstractCommandHandlerTest.
 *
 * @author Denis Lityagin <denis.lityagin@gmail.com>
 */
class AbstractCommandHandlerTest extends TestCase
{
    public function testThatExceptionThrowsIfHandleMethodForCommandIsNotExist(): void
    {
        /** @var Command $command */
        $command = self::getMockForAbstractClass(Command::class);

        /** @var CommandHandler $commandHandler */
        $commandHandler = self::getMockForAbstractClass(CommandHandler::class);

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionCode(Assertion::INVALID_METHOD);

        $commandHandler->handle($command);
    }

    public function testThatHandleMethodForCommandIsCalled(): void
    {
        /** @var Command $command */
        $command = self::getMockBuilder(Command::class)
            ->setMockClassName('FooCommand')
            ->getMockForAbstractClass()
        ;

        $commandHandler = self::getMockBuilder(CommandHandler::class)
            ->setMethods(['handleFooCommand'])
            ->getMockForAbstractClass()
        ;

        $commandHandler
            ->expects(self::once())
            ->method('handleFooCommand')
            ->with($command)
        ;

        /* @var CommandHandler $commandHandler */
        $commandHandler->handle($command);
    }
}
