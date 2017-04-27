<?php

/*
 * This file is part of CQRS package.
 *
 * (c) Denis Lityagin <denis.lityagin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled with this
 * source code in the file LICENSE.
 */

namespace Dlart\CQRS\Query;

use Assert\Assertion;
use Dlart\CQRS\Query\Handler\QueryHandlerInterface as Handler;
use Dlart\CQRS\Query\QueryInterface as Query;
use Dlart\CQRS\Query\Result\QueryResultInterface as Result;

/**
 * QueryBus.
 *
 * @author Denis Lityagin <denis.lityagin@gmail.com>
 */
class QueryBus
{
    /**
     * @var Handler[]
     */
    private $handlers = [];

    /**
     * @param Query $query
     *
     * @return Result
     */
    public function handle(Query $query): Result
    {
        $this->assertThatHandlerForQueryIsRegistered($query);

        return $this->getHandlerForQuery($query)->handle($query);
    }

    /**
     * @param Handler $handler
     * @param string  $fullyQualifiedQueryClassName
     */
    public function registerHandler(
        Handler $handler,
        string $fullyQualifiedQueryClassName
    ): void {
        Assertion::notEmpty($fullyQualifiedQueryClassName);

        $this->handlers[$fullyQualifiedQueryClassName] = $handler;
    }

    /**
     * @param Query $query
     */
    private function assertThatHandlerForQueryIsRegistered(Query $query): void
    {
        Assertion::keyIsset(
            $this->handlers,
            get_class($query)
        );
    }

    /**
     * @param Query $query
     *
     * @return null|Handler
     */
    private function getHandlerForQuery(Query $query): ?Handler
    {
        return $this->handlers[get_class($query)] ?? null;
    }
}
