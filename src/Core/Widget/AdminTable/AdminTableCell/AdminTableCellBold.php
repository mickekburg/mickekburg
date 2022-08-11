<?php

namespace Core\Widget\AdminTable\AdminTableCell;

class AdminTableCellBold extends AbstractAdminTableCell
{
    public function render(): string
    {
        return "<b>".$this->content."</b>>";
    }
}