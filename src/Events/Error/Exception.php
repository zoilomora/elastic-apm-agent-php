<?php

namespace ZoiloMora\ElasticAPM\Events\Error;

use ZoiloMora\ElasticAPM\Events\Common\StacktraceFrame;
use ZoiloMora\ElasticAPM\Helper\Encoding;

/**
 * Information about the originally thrown error.
 */
final class Exception implements \JsonSerializable
{
    /**
     * The error code set when the error happened, e.g. database error code.
     *
     * @var string|int|null
     */
    private $code;

    /**
     * The original error message.
     *
     * @var string|null
     */
    private $message;

    /**
     * Describes the exception type's module namespace.
     *
     * @var string|null
     */
    private $module;

    /**
     * @var object|null
     */
    private $attributes;

    /**
     * @var array|null
     */
    private $stacktrace;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var bool|null
     */
    private $handled;

    /**
     * @var array|null
     */
    private $cause;

    /**
     * @param string|int|null $code
     * @param string|null $message
     * @param string|null $module
     * @param object|null $attributes
     * @param array|null $stacktrace
     * @param string|null $type
     * @param bool|null $handled
     * @param array|null $cause
     */
    public function __construct(
        $code = null,
        $message = null,
        $module = null,
        $attributes = null,
        array $stacktrace = null,
        $type = null,
        $handled = null,
        array $cause = null
    ) {
        if (null === $message && null === $type) {
            throw new \InvalidArgumentException('At least one of the fields (message, type) must be a string.');
        }

        $this->assertInstanceOfElements(StacktraceFrame::CLASS_NAME, $stacktrace);

        $this->code = $code;
        $this->message = $message;
        $this->module = $module;
        $this->attributes = $attributes;
        $this->stacktrace = $stacktrace;
        $this->type = $type;
        $this->handled = $handled;
        $this->cause = $cause;
    }

    /**
     * @param string $class
     * @param array|null $elements
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function assertInstanceOfElements($class, array $elements = null)
    {
        if (null === $elements) {
            return;
        }

        foreach ($elements as $item) {
            if (false === $item instanceof $class) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'All elements must be instances of %s',
                        $class
                    )
                );
            }
        }
    }

    /**
     * @param \Exception $exception
     *
     * @return Exception
     */
    public static function fromException(\Exception $exception)
    {
        return new self(
            $exception->getCode(),
            $exception->getMessage(),
            null,
            null,
            self::mapStacktrace($exception),
            get_class($exception),
            null,
            null
        );
    }

    /**
     * @param \Exception $exception
     *
     * @return array
     */
    private static function mapStacktrace(\Exception $exception)
    {
        $stacktrace = [];

        foreach ($exception->getTrace() as $trace) {
            $stacktrace[] = StacktraceFrame::fromDebugBacktrace($trace);
        }

        return $stacktrace;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'code' => Encoding::keywordField($this->code),
            'message' => $this->message,
            'module' => Encoding::keywordField($this->module),
            'attributes' => $this->attributes,
            'stacktrace' => $this->stacktrace,
            'type' => Encoding::keywordField($this->type),
            'handled' => $this->handled,
            'cause' => $this->cause,
        ];
    }
}
