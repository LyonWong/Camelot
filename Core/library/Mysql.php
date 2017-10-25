<?php

namespace Core\library;

require_once PATH_ROOT.'/library/clsMysql.php';


class Mysql extends \clsMysql
{
    public static $GLOBAL_OPTIONS = [];

    protected static $singletons = [];
    protected $index;
    
    public $DEBUG_RUN = DEBUG_REPORT_OFF;

    public static function inst($index, $space=SPACE)
    {
        if (isset (self::$singletons[$index]) && self::$singletons[$index] instanceof self) {
            $inst = self::$singletons[$index];
        } else {
            $config = \config::load('mysql', $index, null, null, $space);
            $dsn = $config['dsn'] ?: 'mysql:host=localhost';
            $username = $config['username'];
            $password = $config['password'];
            $iOptions = isset($config['options']) ? $config['options'] : [];
            $options = [];
            foreach ($iOptions as $key => $val) {
                $key = defined("\\PDO::$key") ? constant("\\PDO::$key") : $key;
                $val = defined("\\PDO::$val") ? constant("\\PDO::$val") : $val;
                $options[$key] = $val;
            }
            foreach (self::$GLOBAL_OPTIONS as $key => $val) {
                $options[$key] = $val;
            }
            $inst = new self($dsn, $username, $password, $options);
            $inst->index = $index;
            self::$singletons[$index] = $inst;
        }
        return $inst;
    }

    public function showStructure($database)
    {
        $structures = [];
        $this->exec("USE `$database`");
        $tables = $this->query("SHOW TABLES")->fetchAll(null, 0);
        foreach ($tables as $table) {
            $structure = $this->query("SHOW CREATE TABLE `$table`")->fetch(1);
            $structure = str_replace('CREATE TABLE', /** @lang text */
                'CREATE TABLE IF NOT EXISTS', $structure);
            $structure = preg_replace('#AUTO_INCREMENT=\d+ #', '', $structure);
            $structures[$table] = $structure;
        }
        return $structures;
    }

    protected function log($content)
    {
        \output::debug('mysql', $content, DEBUG_SLOT_NOTE);
    }

    protected function hook()
    {
        parent::hook(); // TODO: Change the autogenerated stub
        \output::debug('mysql', $this->lastRunInfo, DEBUG_SLOT_TEMP, $this->DEBUG_RUN);
    }

}