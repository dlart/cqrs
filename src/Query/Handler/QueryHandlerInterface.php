<?php

/*
 * This file is part of CQRS package.
 *
 * (c) Denis Lityagin <denis.lityagin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled with this
 * source code in the file LICENSE.
 */

namespace Dlart\CQRS\Query\Handler;

use Dlart\CQRS\Query\QueryInterface as Query;
use Dlart\CQRS\Query\Result\QueryResultInterface as Result;

/**
 * QueryHandlerInterface.
 *
 * @author Denis Lityagin <denis.lityagin@gmail.com>
 */
interface QueryHandlerInterface
{
    /**
     * @param Query $query
     *
     * @return Result
     */
    public function handle(Query $query): Result;
}
