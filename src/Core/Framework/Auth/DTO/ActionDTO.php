<?php

namespace Core\Framework\Auth\DTO;

class ActionDTO
{
    public const ACTION_NONE = 'none';
    public const ACTION_VIEW = 'view';
    public const ACTION_EDIT = 'edit';
    public const ACTION_DELETE = 'delete';
    public const ACTION_ADD = 'add';

    private string $action;

    public function __construct(string $action)
    {
        $action = strtolower(str_replace("action", "", $action));
        if (in_array($action, [self::ACTION_VIEW, self::ACTION_EDIT, self::ACTION_DELETE, self::ACTION_ADD])) {
            $this->action = $action;
        } else {
            $this->action = self::ACTION_VIEW;
        }
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }


}