<?php

namespace Asynit\Output;

use React\EventLoop\LoopInterface;

/**
 * Allow to detect current environment and choose an way of output that correspond.
 */
class Detector
{
    private $loop;

    public function __construct(LoopInterface $loop)
    {
        $this->loop = $loop;
    }

    /**
     * Return the output to use given the current environment.
     *
     * @return OutputInterface
     */
    public function detect($forceTty = false, $forceNoTty = false)
    {
        if ($forceTty) {
            return new Tty($this->loop);
        }

        if ($forceNoTty) {
            return new Simple();
        }

        // Return simple output if no posix methods
        if (!function_exists('posix_isatty')) {
            return new Simple();
        }

        // Return simple output if not tty
        if (!posix_isatty(STDOUT)) {
            return new Simple();
        }

        // Return tty output when STDOUT is a tty
        return new Tty($this->loop);
    }
}
