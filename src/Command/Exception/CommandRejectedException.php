<?php

/*
 * This file is part of CQRS package.
 *
 * (c) Denis Lityagin <denis.lityagin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled with this
 * source code in the file LICENSE.
 */

namespace Dlart\CQRS\Command\Exception;

use RuntimeException;

/**
 * CommandRejectedException.
 *
 * @author Denis Lityagin <denis.lityagin@gmail.com>
 */
class CommandRejectedException extends RuntimeException
{
}
