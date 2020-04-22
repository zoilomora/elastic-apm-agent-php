<?php

namespace ZoiloMora\ElasticAPM\Events\Common;

class StacktraceFrame implements \JsonSerializable
{
    const CLASS_NAME = __CLASS__;

    /**
     * The absolute path of the file involved in the stack frame
     *
     * @var string|null
     */
    private $absPath;

    /**
     * Column number
     *
     * @var int|null
     */
    private $colno;

    /**
     * The line of code part of the stack frame
     *
     * @var string|null
     */
    private $contextLine;

    /**
     * The relative filename of the code involved in the stack frame, used e.g. to do error checksumming
     *
     * @var string|null
     */
    private $filename;

    /**
     * The classname of the code involved in the stack frame
     *
     * @var string|null
     */
    private $classname;

    /**
     * The function involved in the stack frame
     *
     * @var string|null
     */
    private $function;

    /**
     * A boolean, indicating if this frame is from a library or user code
     *
     * @var bool|null
     */
    private $libraryFrame;

    /**
     * The line number of code part of the stack frame, used e.g. to do error checksumming
     *
     * @var int|null
     */
    private $lineno;

    /**
     * The module to which frame belongs to
     *
     * @var string|null
     */
    private $module;

    /**
     * The lines of code after the stack frame
     *
     * @var array|null
     */
    private $postContext;

    /**
     * The lines of code before the stack frame
     *
     * @var array|null
     */
    private $preContext;

    /**
     * Local variables for this stack frame
     *
     * @var array|null
     */
    private $vars;

    /**
     * @param string|null $absPath
     * @param int|null $colno
     * @param string|null $contextLine
     * @param string $filename
     * @param string $classname
     * @param string|null $function
     * @param bool|null $libraryFrame
     * @param int|null $lineno
     * @param string|null $module
     * @param array|null $postContext
     * @param array|null $preContext
     * @param array|null $vars
     */
    public function __construct(
        $absPath = null,
        $colno = null,
        $contextLine = null,
        $filename = null,
        $classname = null,
        $function = null,
        $libraryFrame = null,
        $lineno = null,
        $module = null,
        array $postContext = null,
        array $preContext = null,
        array $vars = null
    ) {
        $this->absPath = $absPath;
        $this->colno = $colno;
        $this->contextLine = $contextLine;
        $this->filename = $filename;
        $this->classname = $classname;
        $this->function = $function;
        $this->libraryFrame = $libraryFrame;
        $this->lineno = $lineno;
        $this->module = $module;
        $this->postContext = $postContext;
        $this->preContext = $preContext;
        $this->vars = $vars;

        if (null === $this->classname && null === $this->filename) {
            throw new \InvalidArgumentException('At least one of the fields (classname, filename) must be a string');
        }
    }

    /**
     * @param array $debugBacktrace
     *
     * @return StacktraceFrame
     */
    public static function fromDebugBacktrace(array $debugBacktrace)
    {
        $file = self::valueOrNull($debugBacktrace, 'file');
        $class = self::valueOrNull($debugBacktrace, 'class');

        return new self(
            $file,
            null,
            null,
            null !== $file ? basename($file) : null,
            $class,
            self::valueOrNull($debugBacktrace, 'function'),
            null,
            self::valueOrNull($debugBacktrace, 'line'),
            $class,
            null,
            null,
            self::argsFromDebugBacktrace($debugBacktrace)
        );
    }

    /**
     * @param array $array
     * @param string $key
     *
     * @return mixed|null
     */
    private static function valueOrNull(array $array, $key)
    {
        return true === array_key_exists($key, $array)
            ? $array[$key]
            : null;
    }

    /**
     * @param array $debugBacktrace
     *
     * @return array|null
     */
    private static function argsFromDebugBacktrace(array $debugBacktrace)
    {
        if (false === array_key_exists('args', $debugBacktrace)) {
            return null;
        }

        $arguments = $debugBacktrace['args'];

        $args = [];
        foreach ($arguments as $argument) {
            if (true === is_object($argument)) {
                $args[] = 'Instance of ' . get_class($argument);

                continue;
            }

            $args[] = $argument;
        }

        return 0 === count($args)
            ? null
            : $args;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'abs_path' => $this->absPath,
            'colno' => $this->colno,
            'context_line' => $this->contextLine,
            'filename' => $this->filename,
            'classname' => $this->classname,
            'function' => $this->function,
            'library_frame' => $this->libraryFrame,
            'lineno' => $this->lineno,
            'module' => $this->module,
            'post_context' => $this->postContext,
            'pre_context' => $this->preContext,
            'vars' => null === $this->vars
                ? null
                : (object) $this->vars,
        ];
    }
}
