<?php

namespace Core\Widget\AdminTable\DTO;

class AdminTableColumnDTO
{
    private string $filter_cell;
    private string $order_cell;
    private string $th_cell;

    public function __construct(string $th_cell, string $filter_cell = "", string $order_cell = "")
    {
        $this->filter_cell = $filter_cell;
        $this->order_cell = $order_cell;
        $this->th_cell = $th_cell;
    }

    /**
     * @return string
     */
    public function getFilterCell(): string
    {
        return $this->filter_cell;
    }

    /**
     * @return string
     */
    public function getOrderCell(): string
    {
        return $this->order_cell;
    }

    /**
     * @return string
     */
    public function getThCell(): string
    {
        return $this->th_cell;
    }


}