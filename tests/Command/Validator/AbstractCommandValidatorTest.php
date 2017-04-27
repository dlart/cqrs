<?php

/*
 * This file is part of CQRS package.
 *
 * (c) Denis Lityagin <denis.lityagin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled with this
 * source code in the file LICENSE.
 */

namespace Dlart\CQRS\Tests\Command\Validator;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use Dlart\CQRS\Command\CommandInterface as Command;
use Dlart\CQRS\Command\Validator\AbstractCommandValidator as CommandValidator;
use PHPUnit\Framework\TestCase;

/**
 * AbstractCommandValidatorTest.
 *
 * @author Denis Lityagin <denis.lityagin@gmail.com>
 */
class AbstractCommandValidatorTest extends TestCase
{
    public function testThatExceptionThrowsIfHandleMethodForCommandIsNotExist(): void
    {
        /** @var Command $command */
        $command = self::getMockForAbstractClass(Command::class);

        /** @var CommandValidator $commandValidator */
        $commandValidator = self::getMockForAbstractClass(
            CommandValidator::class
        );

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionCode(Assertion::INVALID_METHOD);

        $commandValidator->handle($command);
    }

    public function testThatHandleMethodForCommandIsCalled(): void
    {
        /** @var Command $command */
        $command = self::getMockBuilder(Command::class)
            ->setMockClassName('FooCommand')
            ->getMockForAbstractClass()
        ;

        $commandValidator = self::getMockBuilder(CommandValidator::class)
            ->setMethods(['handleFooCommand'])
            ->getMockForAbstractClass()
        ;

        $commandValidator->expects(self::once())
            ->method('handleFooCommand')
            ->with($command)
        ;

        /* @var CommandValidator $commandValidator */
        $commandValidator->handle($command);
    }
}
