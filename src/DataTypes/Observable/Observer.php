<?php
declare(strict_types=1);

namespace Echron\DataTypes\Observable;

use Echron\DataTypes\Observable\Context\Context;

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
