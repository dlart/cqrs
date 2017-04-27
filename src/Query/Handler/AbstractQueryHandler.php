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
        $this->assertThatHandleMethodForQueryIsExist($query);

        $handleMethod = $this->getHandleMethodNameForQuery($query);

        return $this->$handleMethod($query);
    }

    /**
     * @param Query $query
     */
    private function assertThatHandleMethodForQueryIsExist(
        Query $query
    ): void {
        Assertion::methodExists(
            $this->getHandleMethodNameForQuery($query),
            $this
        );
    }

    /**
     * @param Query $query
     *
     * @return string
     */
    private function getHandleMethodNameForQuery(Query $query): string
    {
        return 'handle'.$this->getNameOfQuery($query);
    }

    /**
     * @param Query $query
     *
     * @return string
     */
    private function getNameOfQuery(Query $query): string
    {
        $fullyQualifiedQueryClassParts = explode('\\', get_class($query));

        return end($fullyQualifiedQueryClassParts);
    }
}
