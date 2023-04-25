<?php

namespace Core\Common\Repository;

interface ICommonRepository
{
    public function getParents(int $item_id): array;
}