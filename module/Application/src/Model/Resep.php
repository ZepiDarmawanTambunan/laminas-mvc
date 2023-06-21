<?php
namespace Application\Model;

class Resep
{
    public $id;
    public $nama;
    public $bahan;
    public $langkah;

    public function exchangeArray(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->nama = $data['nama'] ?? null;
        $this->bahan = $data['bahan'] ?? null;
        $this->langkah = $data['langkah'] ?? null;
    }
}