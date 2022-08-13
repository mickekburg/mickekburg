<?php

namespace Core\AdminTable\Widget\AdminTableCell;

class AdminTableCellBold extends AbstractAdminTableCell
{
    public function render(): string
    {
        return "<b>".$this->content."</b>>";
    }
}