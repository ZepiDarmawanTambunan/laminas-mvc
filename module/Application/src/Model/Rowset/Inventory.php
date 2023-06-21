<?php

namespace Application\Model\Rowset;

use Laminas\Filter\ToInt;

class Inventory extends AbstractModel implements \Laminas\InputFilter\InputFilterAwareInterface
{

    public $inputFilter = null;
    public $title = null;
    public $description = null;
    public $qty = null;
    public $id = null;

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

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }

    public function exchangeArray(array $row)
    {
        $this->id = (!empty($row['id'])) ? $row['id'] : null;
        $this->title = (!empty($row['title'])) ? $row['title'] : null;
        $this->description = (!empty($row['description'])) ? $row['description'] : null;
        $this->qty = (!empty($row['qty'])) ? $row['qty'] : null;
        $this->id = (!empty($row['id'])) ? $row['id'] : null;
    }

    public function getArrayCopy()
    {
        return[
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'qty' => $this->getQty(),
            'id' => $this->getId(),
        ];
    }

    public function getInputFilter(bool $includeIdField = true)
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new \Laminas\InputFilter\InputFilter();

        if ($includeIdField) {
            $inputFilter->add([
                'name' => 'id',
                'required' => true,
                'filters' => [
                    ['name' => ToInt::class],
                ],
            ]);
        }
        $inputFilter->add([
            'name' => 'title',
            'required' => true,
        ]);

        $inputFilter->add([
            'name' => 'description',
        ]);

        $inputFilter->add([
            'name' => 'qty',
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);


        $this->inputFilter = $inputFilter;
        return $inputFilter;
    }

    public function setInputFilter(\Laminas\InputFilter\InputFilterInterface $inputFilter)
    {
        throw new DomainException('This class does not support adding of extra input filters');
    }
}