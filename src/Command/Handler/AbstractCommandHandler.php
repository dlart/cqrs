<?php

/*
 * This file is part of CQRS package.
 *
 * (c) Denis Lityagin <denis.lityagin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled with this
 * source code in the file LICENSE.
 */

namespace Dlart\CQRS\Command\Handler;

use Assert\Assertion;
use Dlart\CQRS\Command\CommandInterface as Command;
use Dlart\CQRS\Command\Handler\CommandHandlerInterface as CommandHandler;
use Verraes\ClassFunctions\ClassFunctions;

/**
 * AbstractCommandHandler.
 *
 * @author Denis Lityagin <denis.lityagin@gmail.com>
 */
abstract class AbstractCommandHandler implements CommandHandler
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
