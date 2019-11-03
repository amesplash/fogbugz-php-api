<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation;

use Amesplash\FogBugzApi\Foundation\Contract\Entity as EntityContract;
use Amesplash\FogBugzApi\Foundation\Exception\MutationWasNotAllowed;
use Amesplash\FogBugzApi\Foundation\State\Immutable;
use Amesplash\FogBugzApi\Foundation\State\ImmutableType;
use JsonSerializable;
use function json_encode;
use function property_exists;

abstract class Entity extends Immutable implements
    EntityContract,
    JsonSerializable
{
    protected function with(array $properties) : self
    {
        if (parent::isInitialized()) {
            $object = clone $this;
        } else {
            $object = $this;
        }

        foreach ($properties as $name => $value) {
            if (! property_exists($this, $name)) {
                throw MutationWasNotAllowed::forObject($this);
            }

            ImmutableType::assertImmutable($value, $name);

            $object->$name = $value;
        }

        return $object;
    }

    /**
     * Returns the array representation this entity
     */
    abstract public function arrayCopy() : array;

    /**
     * Returns the JSON representation this entity
     */
    public function jsonCopy(int $options = 0, int $depth = 512) : string
    {
        return (string) json_encode($this->arrayCopy(), $options, $depth);
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->arrayCopy();
    }
}
