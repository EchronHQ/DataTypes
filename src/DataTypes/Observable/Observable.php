<?php
declare(strict_types=1);

namespace Echron\DataTypes\Observable;

use Echron\DataTypes\Observable\Context\Context;

interface Observable
{
    /**
     * Attach an SplObserver
     *
     * @param Observer $observer
     * @return mixed
     */
    function attach(Observer $observer);

    /**
     * Detach an observer
     *
     * @param Observer $observer
     * @return mixed
     */
    function detach(Observer $observer);

    /**
     * Notify an observer
     *
     * @param $context
     * @return mixed
     */
    function notify(Context $context);
}
