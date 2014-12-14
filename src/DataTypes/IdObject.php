<?php
namespace DataTypes;

class IdObject extends BasicObject
{
    private $id;

    public function __construct($id)
    {

        $this->setId($id);

    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (is_numeric($id)) {

        }
        $id = BasicObject::formatId($id);

        $this->id = $id;

    }

}