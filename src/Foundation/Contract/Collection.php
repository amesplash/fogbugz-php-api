<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation\Contract;

use ArrayAccess;
use Closure;
use Countable;
use IteratorAggregate;
use JsonSerializable;

interface Collection extends
    Countable,
    IteratorAggregate,
    ArrayAccess,
    JsonSerializable
{
    /**
     * Checks whether the collection is empty (contains no elements).
     *
     * @return bool TRUE if the collection is empty, FALSE otherwise.
     */
    public function isEmpty() : bool;

    /**
     * Sets the internal iterator to the first element in the
     * collection and returns this element.
     *
     * @return mixed
     */
    public function first();

    /**
     * Sets the internal iterator to the last element in the collection
     * and returns this element.
     *
     * @return mixed
     */
    public function last();

    /**
     * Checks whether the collection contains an element with
     * the specified key/index.
     *
     * @param string|int $key The key/index to check for.
     *
     * @return bool TRUE if the collection contains an element
     * with the specified key/index, FALSE otherwise.
     */
    public function containsKey($key) : bool;

    /**
     * Checks whether an element is contained in the collection.
     *
     *  @param mixed $element The element to search for.
     *
     *  @psalm-param mixed $element
     */
    public function contains($element) : bool;

    /**
     * Gets the element at the specified key/index.
     *
     * @param string|int $key The key/index of the element to retrieve.
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Gets all keys/indices of the collection.
     *
     * @return array<int, int|string> The keys/indices of the collection,
     * in the order of the corresponding elements in the collection.
     */
    public function getKeys() : array;

    /**
     * Gets all values of the collection.
     *
     * @return array The values of all elements in the collection,
     * in the order they  appear in the collection.
     */
    public function getValues() : array;

    /**
     * Gets the index/key of a given element. The comparison of
     * two elements is strict, that means not only the value
     * but also the type must match.
     * For objects this means reference equality.
     *
     * @param mixed $element The element to search for.
     *
     * @return int|string|bool The key/index of the element or
     * FALSE if the element was not found.
     */
    public function indexOf($element);

    /**
     * Clears the collection, removing all elements.
     */
    public function clear() : self;

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function with($key, $value) : self;

    /**
     * Removes the element at the specified index from the collection.
     *
     * @param mixed ...$keys The key/index of the element to remove.
     */
    public function without(...$keys) : self;

    public function replace(array $data) : self;

    /**
     * Returns all the elements of this collection that satisfy the predicate p.
     * The order of the elements is preserved.
     *
     * @param Closure $p The predicate used for filtering.
     *
     * @return Collection A collection with the results of the filter operation.
     */
    public function filter(Closure $p) : self;

    /**
     * Applies the given function to each element in the collection and returns
     * a new collection with the elements returned by the function.
     *
     * @return Collection
     */
    public function map(Closure $func) : self;

    /**
     * Return an array representaion of the collection.
     */
    public function arrayCopy() : array;

    /**
     * Return a JSON striong representaion of the collection.
     */
    public function jsonCopy(int $options = 0, int $depth = 512) : string;
}
