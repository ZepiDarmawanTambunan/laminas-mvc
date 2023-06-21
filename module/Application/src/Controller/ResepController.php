<?php
namespace Application\Controller;

use Application\Model\ResepTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ResepController extends AbstractActionController
{
    private $table;

    public function __construct(ResepTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        $rows = $this->table->fetchAll();
        dd($rows->buffer());
        $reseps = [];
    }
}