<?php


namespace Core;


class unitQuery
{
    const _LIST_ = [];

    public $params = [];

    public function __construct(array $params)
    {
        $this->params = $params;
        foreach ($params as $key => $val) {
            $this->$key = $val;
        }
    }

    public function toWhere()
    {
        $where = [];
        foreach ($this::_LIST_ as $key) {
            if (isset($this->$key)) {
                $where[$key] = $this->$key;
            }
        }
        return $where;
    }

}
