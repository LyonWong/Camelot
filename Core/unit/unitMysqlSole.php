<?php


namespace Core;


trait unitMysqlSole
{
    /**
     * @var library\Mysql
     */
    protected $mysql;

    protected $TABLE;

    final public function insert($data, $onDuplicate = null)
    {
        return $this->mysql->insert($this->TABLE, $data, $onDuplicate);
    }

    final public function delete($where, $_ = null)
    {
        return $this->mysql->delete($this->TABLE, $where, $_);
    }

    final public function update($data, $where, $_ = null)
    {
        return $this->mysql->update($this->TABLE, $data, $where, $_);
    }

    final public function fetchOne($fields, $where, $index = null)
    {
        return $this->mysql->select($this->TABLE, $fields, $where)->fetch($index);
    }

    final public function fetchAll($fields, $where, $index = null, $value = null)
    {
        return $this->mysql->select($this->TABLE, $fields, $where)->fetchAll($index, $value);
    }
}
