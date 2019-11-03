<?php

declare(strict_types=1);

namespace Amesplash\FogBugzApi\Foundation\Exception;

use function sprintf;

class NotFound extends Exception
{
    public static function clientContactWithId(int $id) : self
    {
        return new self(sprintf('Client Contact [%d] not found', $id), 401);
    }

    public static function clientWithId(int $id) : self
    {
        return new self(sprintf('Client [%d] not found', $id), 401);
    }

    public static function invoiceMessageWithId(int $id) : self
    {
        return new self(sprintf('Invoice Message [%d] not found', $id), 401);
    }

    public static function invoicePaymentWithId(int $id) : self
    {
        return new self(sprintf('Invoice Payment [%d] not found', $id), 401);
    }

    public static function invoiceWithId(int $id) : self
    {
        return new self(sprintf('Invoice [%d] not found', $id), 401);
    }

    public static function invoiceItemCategoryWithId(int $id) : self
    {
        return new self(
            sprintf('Invoice Item Category [%d] not found', $id),
            401
        );
    }

    public static function estimateMessageWithId(int $id) : self
    {
        return new self(sprintf('Estimate Message [%d] not found', $id), 401);
    }

    public static function estimateWithId(int $id) : self
    {
        return new self(sprintf('Estimate [%d] not found', $id), 401);
    }

    public static function estimateItemCategoryWithId(int $id) : self
    {
        return new self(
            sprintf('Estimate Item Category [%d] not found', $id),
            401
        );
    }

    public static function expenseWithId(int $id) : self
    {
        return new self(sprintf('Expense [%d] not found', $id), 401);
    }

    public static function expenseCategoryWithId(int $id) : self
    {
        return new self(sprintf('Expense Category [%d] not found', $id), 401);
    }

    public static function taskWithId(int $id) : self
    {
        return new self(sprintf('Task [%d] not found', $id), 401);
    }

    public static function timeEntrieWithId(int $id) : self
    {
        return new self(sprintf('Time Entrie [%d] not found', $id), 401);
    }

    public static function projectUserAssignmentWithId(int $id) : self
    {
        return new self(
            sprintf('Project User Assignment [%d] not found', $id),
            401
        );
    }

    public static function projectTaskAssignmentWithId(int $id) : self
    {
        return new self(
            sprintf('Project Task Assignment [%d] not found', $id),
            401
        );
    }

    public static function projectWithId(int $id) : self
    {
        return new self(sprintf('Project [%d] not found', $id), 401);
    }

    public static function roleWithId(int $id) : self
    {
        return new self(sprintf('Role [%d] not found', $id), 401);
    }

    public static function userBillableRateWithId(int $id) : self
    {
        return new self(sprintf('User Billable Rate [%d] not found', $id), 401);
    }

    public static function userCostRateWithId(int $id) : self
    {
        return new self(sprintf('User Cost Rate [%d] not found', $id), 401);
    }

    public static function userProjectAssignmentWithId(int $id) : self
    {
        return new self(
            sprintf('User Project Assignment [%d] not found', $id),
            401
        );
    }

    public static function userWithId(int $id) : self
    {
        return new self(sprintf('User [%d] not found', $id), 401);
    }
}
