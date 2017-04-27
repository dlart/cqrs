<?php

/*
 * This file is part of CQRS package.
 *
 * (c) Denis Lityagin <denis.lityagin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled with this
 * source code in the file LICENSE.
 */

namespace Dlart\CQRS\Tests\Query;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Dlart\CQRS\Query\Handler\AbstractQueryHandler as QueryHandler;
use Dlart\CQRS\Query\QueryBus as QueryBus;
use Dlart\CQRS\Query\QueryInterface as Query;
use PHPUnit\Framework\TestCase;

/**
 * QueryBusTest.
 *
 * @author Denis Lityagin <denis.lityagin@gmail.com>
 */
class QueryBusTest extends TestCase
{
    public function testThatQueryMustBeProvidedOnHandlerRegistering(): void
    {
        $queryHandler = self::getMockForAbstractClass(QueryHandler::class);

        $queryBus = new QueryBus();

        self::expectException(AssertionFailedException::class);
        self::expectExceptionCode(Assertion::VALUE_EMPTY);

        $queryBus->registerHandler($queryHandler, '');
    }

    public function testThatRegisteredHandlerForQueryIsCalled(): void
    {
        $query = self::getMockBuilder(Query::class)
            ->setMockClassName('FooQuery')
            ->getMockForAbstractClass()
        ;

        $queryHandler = self::getMockBuilder(QueryHandler::class)
            ->setMethods(['handle'])
            ->getMockForAbstractClass()
        ;

        $queryHandler
            ->expects(self::once())
            ->method('handle')
            ->with($query)
        ;

        $queryBus = new QueryBus();

        $queryBus->registerHandler($queryHandler, get_class($query));

        $queryBus->handle($query);
    }
}
