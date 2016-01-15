<?php
declare(strict_types = 1);
namespace DataTypes\Observable;

use DataTypes\Observable\Context\Context;

interface Observer
{
    /**
     * Receive update from subject
     *
     * @param Observable $subject
     * @param Context $context
     * @return mixed
     */
    public function update(Observable $subject, Context $context);
}
