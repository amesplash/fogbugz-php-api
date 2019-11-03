<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation\Collection;

use Amesplash\FogBugzApi\Foundation\Contract\Collection;
use Amesplash\FogBugzApi\Foundation\State\Immutable;
use Amesplash\FogBugzApi\Foundation\State\ImmutableType;
use ArrayIterator;
use Closure;
use Traversable;
use const ARRAY_FILTER_USE_BOTH;
use function array_filter;
use function array_intersect_key;
use function array_key_exists;
use function array_keys;
use function array_map;
use function array_search;
use function array_values;
use function count;
use function end;
use function in_array;
use function is_array;
use function json_encode;
use function reset;
use function spl_object_hash;

class ArrayCollection extends Immutable implements Collection
{
    /** @var array<mixed> */
    private $elements = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $elements)
    {
        $this->set($elements);
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty() : bool
    {
        return empty($this->elements);
    }

    /**
     * {@inheritDoc}
     */
    public function first()
    {
        return reset($this->elements);
    }

    /**
     * {@inheritDoc}
     */
    public function last()
    {
        return end($this->elements);
    }

    /**
     * {@inheritdoc}
     */
    public function containsKey($key) : bool
    {
        return isset($this->elements[$key])
            || array_key_exists($key, $this->elements);
    }

    /**
     * {@inheritDoc}
     */
    public function contains($element) : bool
    {
        return in_array($element, $this->elements, true);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->elements[$key] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function getKeys() : array
    {
        return array_keys($this->elements);
    }

    /**
     * {@inheritdoc}
     */
    public function getValues() : array
    {
        return array_values($this->elements);
    }

    /**
     * {@inheritdoc}
     */
    public function indexOf($element)
    {
        return array_search($element, $this->elements, true);
    }

    /**
     * {@inheritdoc}
     */
    public function clear() : Collection
    {
        $clone = clone $this;
        $clone->elements = [];

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function with($key, $value) : Collection
    {
        $clone = clone $this;
        $clone->set([$key => $value]);

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function without(...$keys) : Collection
    {
        $clone = clone $this;
        foreach ($keys as $key) {
            unset($clone->elements[$key]);
        }

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function replace(array $elements) : Collection
    {
        $clone = clone $this;
        $clone->set($elements);

        return $clone;
    }

    protected function createFromArray(array $elements) : Collection
    {
        $clone = clone $this;
        $clone->elements = [];
        $clone->set($elements);

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(Closure $p) : Collection
    {
        return $this->createFromArray(
            array_filter($this->elements, $p, ARRAY_FILTER_USE_BOTH)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function map(Closure $func) : Collection
    {
        return $this->createFromArray(
            array_map($func, $this->elements)
        );
    }

    /**
     * Required by interface ArrayAccess.
     *
     * {@inheritDoc}
     *
     * @param int|string $offset
     */
    public function offsetExists($offset) : bool
    {
        return $this->containsKey($offset);
    }

    /**
     * Required by interface ArrayAccess.
     *
     * @param int|string $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Required by interface ToString.
     *
     * {@inheritdoc}
     */
    public function __toString() : string
    {
        return self::class . '@' . spl_object_hash($this);
    }

    /**
     * Required by interface IteratorAggregate.
     *
     * {@inheritDoc}
     */
    public function getIterator() : Traversable
    {
        return new ArrayIterator($this->elements);
    }

    /**
     * {@inheritDoc}
     */
    public function arrayCopy() : array
    {
        return $this->elements;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonCopy(int $options = 0, int $depth = 512) : string
    {
        return (string) json_encode($this->jsonSerialize(), $options, $depth);
    }

    /**
     * Required by interface JsonCopy and JsonSerializable.
     *
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return $this->elements;
    }

    /**
     * Required by interface Countable.
     *
     * {@inheritDoc}
     */
    public function count() : int
    {
        return count($this->elements);
    }

    /**
     * {@inheritdoc}
     */
    protected function set(array $elements) : void
    {
        foreach ($elements as $key => $value) {
            if (is_array($value)) {
                $this->elements[$key] = new self($value);
                continue;
            }

            ImmutableType::assertImmutable($value, $key);
            $this->elements[$key] = $value;
        }
    }
}
