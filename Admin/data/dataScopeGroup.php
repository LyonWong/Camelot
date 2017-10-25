<?php


namespace Admin;


use Core\unitInstance;

class dataScopeGroup extends dataSole
{
    use unitInstance;

    const TABLE = 'scope_group';

    /**
     * @return self
     */
    public static function sole()
    {
        return self::_sole();
    }



    public function fetchAuths(...$groupIds):array
    {
        if (count($groupIds) == 0) {
            return [];
        }
        $list = $this->mysql->s("SELECT `auths` FROM " . self::TABLE)->v("WHERE `id` in", $groupIds)->e()->fetchAll(null, 0);
        foreach ($list as &$item) {
            $item = json_decode($item, true);
        }
        return $list;
    }
    
    public function fetchInfo($groupId):array
    {
        $res = $this->fetchOne('*', ['id'=>$groupId]);
        if ($res) {
            $res['auths'] = json_decode($res['auths'], true);
            return $res;
        } else {
            return [];
        }
    }
    
    public function append($name)
    {
        $data = [
            'name' => $name,
            'auths' => '{}',
        ];
        $this->insert($data);
        return $this->mysql->lastInsertId();
    }

    public function setAuth($groupId, $field, $point, $priv)
    {
        $preAuth = $this->fetchOne('auths', ['id' => $groupId], 0);
        $newAuth = arrayMergeForce(json_decode($preAuth, true), [
            $field => [
                $point => $priv
            ]
        ]);
        $auth = json_encode($newAuth, JSON_FORCE_OBJECT);
        return $this->update(['auths' => $auth], ['id' => $groupId]);
    }


}