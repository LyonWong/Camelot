<?php


namespace Core;


trait unitFile
{
    public function fileWrite($name, $content, $flags=null)
    {
        $file = $this->_spliceFilePath($name);
        file_put_contents($file, $content, $flags);
    }

    public function fileRead($name)
    {
        $file = $this->_spliceFilePath($name);
        return file_get_contents($file);
    }

    public function fileCheck($name)
    {
        $file = $this->_spliceFilePath($name);
        return file_exists($file) ? $file : false;
    }

    private function _spliceFilePath($name)
    {
        $path = PATH_SPACE."/file/$name";
        return $path;
    }

}