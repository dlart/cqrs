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

use Dlart\CQRS\Command\CommandInterface as Command;

/**
 * CommandValidatorInterface.
 *
 * @author Denis Lityagin <denis.lityagin@gmail.com>
 */
interface CommandValidatorInterface
{
    /**
     * @param Command $command
     */
    public function handle(Command $command): void;
}
