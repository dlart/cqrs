<?php

/*
 * This file is part of CQRS package.
 *
 * (c) Denis Lityagin <denis.lityagin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled with this
 * source code in the file LICENSE.
 */

namespace Dlart\CQRS\Tests\Query\Handler;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use Dlart\CQRS\Query\Handler\AbstractQueryHandler as QueryHandler;
use Dlart\CQRS\Query\QueryInterface as Query;
use Dlart\CQRS\Query\Result\QueryResultInterface as QueryResult;
use PHPUnit\Framework\TestCase;

/**
 * AbstractQueryHandlerTest.
 *
 * @author Denis Lityagin <denis.lityagin@gmail.com>
 */
class AbstractQueryHandlerTest extends TestCase
{
    public function testThatExceptionThrowsIfHandleMethodForQueryIsNotExist(): void
    {
        /** @var Query $query */
        $query = self::getMockForAbstractClass(Query::class);

        /** @var QueryHandler $queryHandler */
        $queryHandler = self::getMockForAbstractClass(QueryHandler::class);

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionCode(Assertion::INVALID_METHOD);

        $queryHandler->handle($query);
    }

    public function testThatHandleMethodForQueryIsCalled(): void
    {
        /** @var Query $query */
        $query = self::getMockBuilder(Query::class)
            ->setMockClassName('FooQuery')
            ->getMockForAbstractClass()
        ;

        $queryHandler = self::getMockBuilder(QueryHandler::class)
            ->setMethods(['handleFooQuery'])
            ->getMockForAbstractClass()
        ;

        $queryResult = self::getMockForAbstractClass(QueryResult::class);

        $queryHandler
            ->expects(self::once())
            ->method('handleFooQuery')
            ->with($query)
            ->willReturn($queryResult)
        ;

        /* @var QueryHandler $queryHandler */
        $queryHandler->handle($query);
    }
}
