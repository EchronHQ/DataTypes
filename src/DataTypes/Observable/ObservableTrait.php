<?php
declare(strict_types = 1);
namespace DataTypes\Observable;

use DataTypes\Observable\Context\Context;

trait ObservableTrait
{
    private $observers = [];

    public function attach(Observer $observer_in)
    {
        //could also use array_push($this->observers, $observer_in);
        $this->observers[] = $observer_in;
    }

    public function detach(Observer $observer_in)
    {
        //$key = array_search($observer_in, $this->observers);
        foreach ($this->observers as $okey => $oval) {
            if ($oval == $observer_in) {
                unset($this->observers[$okey]);
            }
        }
    }

    public function notify(Context $context)
    {
        /** @var Observer $obs */
        foreach ($this->observers as $obs) {
            if ($this instanceof Observable) {
                $obs->update($this, $context);
            } else {
                throw new \Exception('In order to notify observers, the object should inherit from ' . Observable::class);
            }
        }
    }
}
