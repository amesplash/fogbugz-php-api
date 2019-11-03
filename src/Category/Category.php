<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Category;

use Amesplash\FogBugzApi\Foundation\Entity;

final class Category extends Entity
{
    /** @var int */
    private $id;

    /** @var string */
    private $label;

    /** @var string */
    private $pluralLabel;

    /** @var int */
    private $defaultStatusId;

    /** @var bool */
    private $forScheduledItem;

    /** @var int */
    private $iconTypeId;

    /** @var int */
    private $attachmentIconId;

    /** @var int */
    private $activeDefaultStatusId;

    /** @var int */
    private $order;

    public function __construct(
        int $id,
        string $label,
        string $pluralLabel,
        int $defaultStatusId,
        bool $forScheduledItem,
        int $iconTypeId,
        int $attachmentIconId,
        int $activeDefaultStatusId,
        int $order
    ) {
        $this->id = $id;
        $this->label = $label;
        $this->pluralLabel = $pluralLabel;
        $this->defaultStatusId = $defaultStatusId;
        $this->forScheduledItem = $forScheduledItem;
        $this->iconTypeId = $iconTypeId;
        $this->attachmentIconId = $attachmentIconId;
        $this->activeDefaultStatusId = $activeDefaultStatusId;
        $this->order = $order;

        parent::__construct();
    }

    public function id() : int
    {
        return $this->id;
    }

    public function label() : string
    {
        return $this->label;
    }

    public function pluralLabel() : string
    {
        return $this->pluralLabel;
    }

    public function defaultStatusId() : int
    {
        return $this->defaultStatusId;
    }

    public function forScheduledItem() : bool
    {
        return $this->forScheduledItem;
    }

    public function iconTypeId() : int
    {
        return $this->iconTypeId;
    }

    public function attachmentIconId() : int
    {
        return $this->attachmentIconId;
    }

    public function activeDefaultStatusId() : int
    {
        return $this->activeDefaultStatusId;
    }

    public function order() : int
    {
        return $this->order;
    }

    public function arrayCopy() : array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'plural_label' => $this->pluralLabel,
            'default_status_id' => $this->defaultStatusId,
            'for_scheduled_item' => $this->forScheduledItem,
            'icon_type_id' => $this->iconTypeId,
            'attachment_icon_id' => $this->attachmentIconId,
            'active_default_status_id' => $this->activeDefaultStatusId,
            'order' => $this->order,
        ];
    }

    public function makeFromArray(array $data) : self
    {
        return new self(
            $data['id'],
            $data['label'],
            $data['plural_label'],
            $data['default_status_id'],
            $data['for_scheduled_item'],
            $data['icon_type_id'],
            $data['attachment_icon_id'],
            $data['active_default_status_id'],
            $data['order']
        );
    }
}
