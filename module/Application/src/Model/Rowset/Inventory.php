<?php

namespace Application\Model\Rowset;

use DomainException;
use Laminas\Filter\ToInt;

class Inventory extends AbstractModel implements \Laminas\InputFilter\InputFilterAwareInterface
{
    private $id = null;
    private $inputFilter = null;
    private $title = null;
    private $description = null;
    private $qty = null;
    private $image = null;

    // get set peritem/column/field
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($value)
    {
        $this->title = $value;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
        return $this;
    }

    public function getQty()
    {
        return $this->qty;
    }

    public function setQty($value)
    {
        $this->qty = $value;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($value)
    {
        $this->image = $value;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }

    // dari database to create object inventory
    public function exchangeArray(array $row)
    {
        $this->id = (!empty($row['id'])) ? $row['id'] : null;
        $this->title = (!empty($row['title'])) ? $row['title'] : null;
        $this->description = (!empty($row['description'])) ? $row['description'] : null;
        $this->qty = (!empty($row['qty'])) ? $row['qty'] : null;
        $this->image = (!empty($row['image'])) ? $row['image'] : null;
    }

    // get inventory
    public function getArrayCopy()
    {
        return[
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'qty' => $this->getQty(),
            'image' => $this->getImage(),
        ];
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new \Laminas\InputFilter\InputFilter();

        $inputFilter->add([
            'name' => 'title',
            'required' => true,
        ]);

        $inputFilter->add([
            'name' => 'image',
            'required' => false
        ]);

        $inputFilter->add([
            'name' => 'description',
            'required' => true,
        ]);

        $inputFilter->add([
            'name' => 'qty',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $inputFilter;
    }

    public function setInputFilter(\Laminas\InputFilter\InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
        return $this;
    }
}