<?php

namespace app\home\controller;

/**
 * 公共用户可以访问的类(不需要登录)
 */
class BaseMall extends BaseHome
{
    public function _initialize()
    {
        parent::_initialize();
        $this->template_dir = $this->template_name.'/mall/'.strtolower(request()->controller()).'/';
    }
    
    
    /*
     * 面包屑导航
     */
    public function get_ancestor($column_id)
    {
        $key = "ancestor_".$column_id;
        $data = rcache($key);
        if (empty($data) && $column_id>0) {
            $ancestor = array();
            $column_mod = model('column');
            for ($i = 0; $i < 100; $i++) {
                $column = $column_mod->getOneColumn($column_id);
                if (!empty($column)) {
                    $ancestor[] = $column;
                } else {
                    break;
                }
                if ($column['parent_id'] == 0) {
                    break;
                } else {
                    $column_id = $column['parent_id'];
                }
            }
            $data = array_reverse($ancestor);
            wcache($key, $data,'',36000);
        }
        return $data;
    }
}