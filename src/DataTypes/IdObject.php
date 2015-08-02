<?php
namespace DataTypes;

class IdObject extends BasicObject
{

    private $id;

    public function __construct($id = null)
    {
        if ($id !== null) {
            $this->setId($id);
        }

    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $id = IdHelper::formatId($id);

        $this->id = $id;

    }

}
