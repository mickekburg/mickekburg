<?php

namespace Core\Widget\AdminTable\View\AdminTableCell;

class AdminTableCellBold extends AbstractAdminTableCell
{
    public function render(): string
    {
        return "<b>".$this->content."</b>>";
    }
}