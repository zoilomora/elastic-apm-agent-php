<?php

namespace ZoiloMora\ElasticAPM;

use ZoiloMora\ElasticAPM\Configuration\CoreConfiguration;
use ZoiloMora\ElasticAPM\Events\Common\Context;
use ZoiloMora\ElasticAPM\Events\Error\Error;
use ZoiloMora\ElasticAPM\Events\Metadata\Metadata;
use ZoiloMora\ElasticAPM\Events\Span\Span;
use ZoiloMora\ElasticAPM\Events\TraceableEvent;
use ZoiloMora\ElasticAPM\Events\Transaction\Transaction;
use ZoiloMora\ElasticAPM\Helper\Stacktrace;
use ZoiloMora\ElasticAPM\Pool\ErrorPool;
use ZoiloMora\ElasticAPM\Pool\PoolFactory;
use ZoiloMora\ElasticAPM\Pool\SpanPool;
use ZoiloMora\ElasticAPM\Pool\TransactionPool;
use ZoiloMora\ElasticAPM\Processor\Handler;
use ZoiloMora\ElasticAPM\Reporter\Reporter;

final class ElasticApmTracer
{
    /**
     * @var self
     */
    private static $instance = null;

    /**
     * @var CoreConfiguration
     */
    private $coreConfiguration;

    /**
     * @var Metadata
     */
    private $metadata;

    /**
     * @var Context
     */
    private $context;

    /**
     * @var Handler
     */
    private $handler;

    /**
     * @var Reporter
     */
    private $reporter;

    /**
     * @var TransactionPool
     */
    private $transactionPool;

    /**
     * @var SpanPool
     */
    private $spanPool;

    /**
     * @var ErrorPool
     */
    private $errorPool;

    public function __construct(
        CoreConfiguration $coreConfiguration,
        Reporter $reporter,
        PoolFactory $poolFactory
    ) {
        $this->coreConfiguration = $coreConfiguration;
        $this->reporter = $reporter;

        $this->metadata = Metadata::create($this->coreConfiguration);
        $this->context = Context::discover();
        $this->handler = Handler::create($this->coreConfiguration);

        $this->transactionPool = $poolFactory->createTransactionPool();
        $this->spanPool = $poolFactory->createSpanPool();
        $this->errorPool = $poolFactory->createErrorPool();
    }

    /**
     * @param ElasticApmTracer|null $instance
     *
     * @return ElasticApmTracer
     *
     * @throws \Exception
     */
    public static function instance(self $instance = null)
    {
        if (null === $instance && null === self::$instance) {
            throw new \Exception('The instance has not yet been injected.');
        }

        if (null !== $instance && null !== self::$instance) {
            throw new \Exception('Already an injected object, it cannot be replaced.');
        }

        if (null !== $instance && null === self::$instance) {
            self::$instance = $instance;
        }

        return self::$instance;
    }

    /**
     * @param string $name
     * @param string $type
     * @param Context $context
     *
     * @return Transaction
     *
     * @throws \Exception
     */
    public function startTransaction($name, $type, $context = null)
    {
        if (null === $context) {
            $context = $this->context;
        }

        $lastEvent = $this->getLastUnfinishedEvent();

        $transaction = new Transaction(
            $name,
            $type,
            $context,
            null !== $lastEvent ? $lastEvent->traceId() : null,
            null !== $lastEvent ? $lastEvent->parentId() : null
        );

        $this->transactionPool->put($transaction);

        return $transaction;
    }

    /**
     * @param string $name
     * @param string $type
     * @param string|null $subtype
     * @param string|null $action
     * @param Events\Span\Context|null $context
     *
     * @return Span
     *
     * @throws \Exception
     */
    public function startSpan(
        $name,
        $type,
        $subtype = null,
        $action = null,
        Events\Span\Context $context = null
    ) {
        $stacktrace = Stacktrace::getDebugBacktrace(
            $this->coreConfiguration->stacktraceLimit()
        );

        $lastTransaction = $this->transactionPool->findLastUnfinished();
        if (null === $lastTransaction) {
            throw new \Exception('To create a span, there must be a transaction started.');
        }

        $lastEvent = $this->getLastUnfinishedEvent();

        $span = new Span(
            $name,
            $type,
            $lastEvent->traceId(),
            $lastEvent->id(),
            $subtype,
            $lastTransaction->id(),
            $action,
            $context,
            $stacktrace
        );

        $this->spanPool->put($span);

        return $span;
    }

    /**
     * @param \Exception $exception
     * @param Context|null $context
     *
     * @return void
     *
     * @throws \Exception
     */
    public function captureException(\Exception $exception, Context $context = null)
    {
        $lastTransaction = $this->transactionPool->findLastUnfinished();
        if (null === $lastTransaction) {
            throw new \Exception('To capture exception, there must be a transaction started.');
        }

        $lastEvent = $this->getLastUnfinishedEvent();

        $error = new Error(
            $lastEvent->traceId(),
            $lastEvent->id(),
            $exception,
            $context,
            $lastTransaction->id()
        );

        $this->errorPool->put($error);
    }

    /**
     * @return void
     */
    public function flush()
    {
        if (false === $this->coreConfiguration->active()) {
            $this->eraseAllPools();

            return;
        }

        $items = $this->getEventsToSend();
        $this->eraseAllPools();

        if (1 === count($items)) {
            return;
        }

        $items = $this->handler->execute($items);

        $this->reporter->report($items);
    }

    /**
     * @return array
     */
    private function getEventsToSend()
    {
        return array_merge(
            [
                $this->metadata,
            ],
            $this->transactionPool->findFinished(),
            $this->spanPool->findFinished(),
            $this->errorPool->findAll()
        );
    }

    /**
     * @return void
     */
    private function eraseAllPools()
    {
        $this->transactionPool->eraseAll();
        $this->spanPool->eraseAll();
        $this->errorPool->eraseAll();
    }

    /**
     * @return TraceableEvent|null
     */
    private function getLastUnfinishedEvent()
    {
        $lastTransaction = $this->transactionPool->findLastUnfinished();
        $lastSpan = $this->spanPool->findLastUnfinished();

        return null !== $lastSpan
            ? $lastSpan
            : $lastTransaction;
    }
}
