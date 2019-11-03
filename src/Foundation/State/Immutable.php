<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation\State;

use Amesplash\FogBugzApi\Foundation\Exception\MutationWasNotAllowed;

abstract class Immutable
{
    /** @var bool */
    private $INITIALIZED = false;

    /**
     * Create a new instance
     */
    public function __construct()
    {
        if ($this->INITIALIZED) {
            throw MutationWasNotAllowed::forObject($this);
        }

        $this->INITIALIZED = true;
    }

    /**
     * @param mixed $value
     *
     * @suppress PhanUnusedPublicFinalMethodParameter
     */
    final public function __set(string $offset, $value) : void
    {
        throw MutationWasNotAllowed::forObject($this);
    }

    /**
     * @suppress PhanUnusedPublicFinalMethodParameter
     */
    final public function __unset(string $offset) : void
    {
        throw MutationWasNotAllowed::forObject($this);
    }

     /**
     * @param int|string|null $offset
     * @param mixed           $value
     *
     * @suppress PhanUnusedPublicFinalMethodParameter
     */
    final public function offsetSet($offset, $value) : void
    {
        throw MutationWasNotAllowed::forObject($this);
    }

    /**
     * @param int|string $offset
     *
     * @suppress PhanUnusedPublicFinalMethodParameter
     */
    final public function offsetUnset($offset) : void
    {
        throw MutationWasNotAllowed::forObject($this);
    }

    final protected function isInitialized() : bool
    {
        return $this->INITIALIZED;
    }
}
