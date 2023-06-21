<?php

namespace Application\Model\Rowset;

use DomainException;
use Laminas\Filter\ToInt;

class Resep extends AbstractModel implements \Laminas\InputFilter\InputFilterAwareInterface
{
    public $id = null;
    public $nama = null;
    public $bahan = null;
    public $langkah = null;
    public $inputFilter = null;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }
    
    public function getNama()
    {
        return $this->nama;
    }

    public function setNama($value)
    {
        $this->nama = $value;
        return $this;
    }

    public function getBahan()
    {
        return $this->bahan;
    }

    public function setBahan($value)
    {
        $this->bahan = $value;
        return $this;
    }

    public function getLangkah()
    {
        return $this->langkah;
    }

    public function setLangkah($value)
    {
        $this->langkah = $value;
        return $this;
    }

    public function exchangeArray(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->nama = $data['nama'] ?? null;
        $this->bahan = $data['bahan'] ?? null;
        $this->langkah = $data['langkah'] ?? null;
    }

    public function getArrayCopy()
    {
        return[
            'id' => $this->getId(),
            'nama' => $this->getNama(),
            'bahan' => $this->getBahan(),
            'langkah' => $this->getLangkah(),
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