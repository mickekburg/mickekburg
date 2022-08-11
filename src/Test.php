<?php

use Folder\Test2;

class Test
{
    public function showOne()
    {
        $test2 = new Test2();
        $test2->showTwo();
    }

    public function returnOne($return = 0): int
    {
        return $return === 0 ? 555 : $return;
    }
}