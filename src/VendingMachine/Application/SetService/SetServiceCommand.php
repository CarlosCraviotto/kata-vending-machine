<?php
declare(strict_types=1);

namespace VendingMachine\Application\SetService;

final class SetServiceCommand
{
    private $type;
    private $data;

    /**
     * SetServiceCommand constructor.
     * @param $type
     * @param $data
     */
    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }


}