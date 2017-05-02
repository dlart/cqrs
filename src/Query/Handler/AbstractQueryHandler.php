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

use Assert\Assertion;
use Dlart\CQRS\Query\Handler\QueryHandlerInterface as QueryHandler;
use Dlart\CQRS\Query\QueryInterface as Query;
use Dlart\CQRS\Query\Result\QueryResultInterface as QueryResult;
use Verraes\ClassFunctions\ClassFunctions;

/**
 * AbstractQueryHandler.
 *
 * @author Denis Lityagin <denis.lityagin@gmail.com>
 */
abstract class AbstractQueryHandler implements QueryHandler
{
    /**
     * @param Query $query
     *
     * @return QueryResult
     */
    public function handle(Query $query): QueryResult
    {
        $handleMethodName = 'handle'.ClassFunctions::short($query);

        Assertion::methodExists(
            $handleMethodName,
            $this
        );

        return $this->$handleMethodName($query);
    }
}
