<?php
declare(strict_types = 1);
namespace DataTypes\Exception;

class NotInCollectionException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
