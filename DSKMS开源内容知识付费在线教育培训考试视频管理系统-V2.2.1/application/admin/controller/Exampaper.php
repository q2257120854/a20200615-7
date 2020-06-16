<?php

namespace app\admin\controller;

use think\Lang;

/**
 * ============================================================================
 * DSMall多用户商城
 * ============================================================================
 * 版权所有 2014-2028 长沙德尚网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.csdeshang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 控制器
 */
class Exampaper extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/exampaper.lang.php');
    }

    /**
     * 试卷列表
     */
    public function index() {
        $exampaper_model = model('exampaper');
        $condition = array();
        $condition['store_id'] = 0;
        //试卷名称
        $exampaper_name = input('param.exampaper_name');
        if (!empty($exampaper_name)) {
            $condition['exampaper_name'] = array('like', "%" . $exampaper_name . "%");
        }
        $exampaper_type = input('param.exampaper_type');
        if ($exampaper_type != '') {
            $condition['exampaper_type'] = $exampaper_type;
        }


        $exampaper_list = $exampaper_model->getExampaperList($condition, 10);
        $this->assign('exampaper_list', $exampaper_list);
        $this->assign('show_page', $exampaper_model->page_info->render());



        $this->setAdminCurItem('index');
        return $this->fetch('index');
    }

    /**
     * 试卷添加
     */
    public function add() {
        $exampaper_model = model('exampaper');
        if (!request()->isPost()) {
            $this->setAdminCurItem('add');
            $exampaper = array(
                'exampaper_type' => 0
            );
            $this->assign('exampaper', $exampaper);
            return $this->fetch('form');
        } else {
            $data = array(
                'exampaper_name' => input('param.exampaper_name'),
                'exampaper_time' => intval(input('param.exampaper_time')),
                'exampaper_type' => intval(input('param.exampaper_type')),
                'exampaper_addtime' => TIMESTAMP,
                'store_id' => 0,
            );
            $result = $exampaper_model->addExampaper($data);
            if ($result) {
                $this->log(lang('ds_add') . lang('limit_exampaper') . '[' . input('post.exampaper_name') . ']', 1);
                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    public function edit() {
        $exampaper_id = intval(input('param.exampaper_id'));
        $exampaper_model = model('exampaper');
        $exampaper = $exampaper_model->getOneExampaper(array('exampaper_id' => $exampaper_id));
        if (empty($exampaper)) {
            $this->error(lang('param_error'));
        }
        if (!request()->isPost()) {
            $this->assign('exampaper', $exampaper);
            return $this->fetch('form');
        } else {
            $data = array(
                'exampaper_name' => input('param.exampaper_name'),
                'exampaper_time' => intval(input('param.exampaper_time')),
            );
            $condition = array(
                'store_id' => 0,
                'exampaper_id' => $exampaper_id,
            );
            $result = $exampaper_model->editExampaper($condition, $data);
            if ($result) {
                $this->log(lang('ds_edit') . lang('limit_exampaper') . '[ID:' . $exampaper_id . ']', 1);
                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 配置考试题目
     */
    public function config() {
        $exampaper_id = intval(input('param.exampaper_id'));
        $exampaper_model = model('exampaper');
        $condition = array(
            'exampaper_id'=>$exampaper_id,
            'store_id'=>0,
        );
        $exampaper = $exampaper_model->getOneExampaper($condition);
        if (empty($exampaper)) {
            $this->error(lang('param_error'));
        }
        if (!request()->isPost()) {
            $exampaper_setting = unserialize($exampaper['exampaper_setting']);
            $exampaper['exampaper_setting'] = $exampaper_setting;
            $this->assign('exampaper', $exampaper);

            $exambank_model = model('exambank');
            $this->assign('exambank_level_list', $exambank_model->getLevelList()); #难度等级
            $this->assign('examtype_list', $exambank_model->getExamtypeList()); #题目类型
            $this->assign('examclass_list', model('examclass')->getTreeClassList(2, 0));
            $this->setAdminCurItem('exampaper_config');
            if ($exampaper['exampaper_type'] == 0) {
                //普通试卷
                return $this->fetch('config_0');
            } else {
                //随机试卷
                return $this->fetch('config_1');
            }
        } else {
            $params = input('param.');
            $exampaper_setting = array();

            if ($exampaper['exampaper_type'] == 0) {
                //普通试卷
                $i = 1;
                foreach ($params['args'] as $key => $value) {
                    $exampaper_setting[$i]['section_name'] = $value['section_name']; //试卷章节名称
                    $exampaper_setting[$i]['section_remark'] = $value['section_remark']; //试卷章节描述
                    if (isset($value['exambank_score'])) {
                        foreach ($value['exambank_score'] as $exambank_score_key => $exambank_score_value) {
                            $exampaper_setting[$i]['items'][$exambank_score_key]['exambank_score'] = $value['exambank_score'][$exambank_score_key];
                            $exambank_id = $value['exambank_id'][$exambank_score_key];
                            $exambank = db('exambank')->where('exambank_id', $exambank_id)->find();
                            //通过设置的 题库ID 获取相关题库数据存储为题库模板
                            $exampaper_setting[$i]['items'][$exambank_score_key]['examtype_id'] = $exambank['examtype_id'];
                            $exampaper_setting[$i]['items'][$exambank_score_key]['exambank_id'] = $exambank_id;
                            $exampaper_setting[$i]['items'][$exambank_score_key]['exambank_question'] = $exambank['exambank_question'];
                            $exampaper_setting[$i]['items'][$exambank_score_key]['exambank_answer'] = $exambank['exambank_answer'];
                            $exampaper_setting[$i]['items'][$exambank_score_key]['exambank_select'] = $exambank['exambank_select'];
                            $exampaper_setting[$i]['items'][$exambank_score_key]['exambank_selectnum'] = $exambank['exambank_selectnum'];
                            $exampaper_setting[$i]['items'][$exambank_score_key]['exambank_describe'] = $exambank['exambank_describe'];
                            $exampaper_setting[$i]['items'][$exambank_score_key]['exambank_level'] = $exambank['exambank_level'];
                        }
                    }
                    $i++;
                }
            } else {
                //随机试卷
                $i = 1;
                if (isset($params['args']['section_name'])) {
                    foreach ($params['args']['section_name'] as $key => $value) {
                        $exampaper_setting[$i]['section_name'] = $params['args']['section_name'][$key];
                        $exampaper_setting[$i]['section_remark'] = $params['args']['section_remark'][$key];
                        $exampaper_setting[$i]['section_type'] = $params['args']['section_type'][$key];
                        $exampaper_setting[$i]['section_level'] = $params['args']['section_level'][$key];
                        $exampaper_setting[$i]['section_nums'] = $params['args']['section_nums'][$key];
                        $exampaper_setting[$i]['section_score'] = $params['args']['section_score'][$key];
                        $i++;
                    }
                }
            }

            $data = array(
                'exampaper_score' => $params['exampaper_score'],
                'exampaper_passscore' => $params['exampaper_passscore'],
                'exampaper_setting' => serialize($exampaper_setting),
            );
            $condition = array(
                'store_id' => 0,
                'exampaper_id' => $exampaper_id,
            );
            $result = $exampaper_model->editExampaper($condition, $data);
            if ($result) {
                $this->log(lang('ds_edit') . lang('limit_exampaper') . '[ID:' . $exampaper_id . ']', 1);
                $this->success(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    public function drop() {
        $exampaper_id = intval(input('param.exampaper_id'));
        if (!empty($exampaper_id)) {
            $exampaper_model = model('exampaper');
            $condition = array(
                'exampaper_id'=>$exampaper_id,
                'store_id'=>0,
            );
            $exampaper_model->delExampaper($condition);
            //删除试卷对应的 考试记录
            model('exampaperlog')->delExampaperlog($condition);
            $this->log(lang('ds_del') . lang('limit_exampaper') . '[ID:' . $exampaper_id . ']', 1);
            ds_json_encode(10000, lang('ds_common_del_succ'));
        } else {
            ds_json_encode(10001, lang('ds_common_del_fail'));
        }
    }

    /**
     * 考试详情
     */
    public function exampaperlog() {
        $exampaper_id = intval(input('param.exampaper_id'));
        $exampaperlog_model = model('exampaperlog');
        $condition = array(
            'exampaper_id'=>$exampaper_id,
            'store_id'=>0,
        );
        $exampaperlog_list = $exampaperlog_model->getExampaperlogList($condition, 10);
        $this->assign('exampaperlog_list', $exampaperlog_list);
        $this->assign('show_page', $exampaperlog_model->page_info->render());

        $this->setAdminCurItem('exampaperlog');
        return $this->fetch();
    }

    /**
     * 批阅试卷
     * check_score 
     * check_remark
     * check_state  Y正确  N错误
     */
    public function exampaperlog_check() {
        //获取试卷答案
        $exampaperlog_id = intval(input('param.exampaperlog_id'));
        $exampaperlog_model = model('exampaperlog');
        $condition = array(
            'exampaperlog_id'=>$exampaperlog_id,
            'store_id'=>0,
        );
        $exampaperlog = $exampaperlog_model->getOneExampaperlog($condition);
        $section_list = unserialize($exampaperlog['exampaperlog_data']);
        $exampaperlog['section_list'] = $section_list;
        if (!request()->isPost()) {
            $this->assign('exampaperlog', $exampaperlog);
            //获取试卷题目
            $exampaper_model = model('exampaper');
            $exampaper = $exampaper_model->getOneExampaper(array('exampaper_id' => $exampaperlog['exampaper_id']));
            $this->assign('exampaper', $exampaper);
            return $this->fetch();
        } else {
            $exampaperlog_score = 0; #考试批改后得分
            $check_state = input('param.check_state/a'); #答案状态
            $check_score = input('param.check_score/a'); #批改评分
            foreach ($section_list as $section_key => $section_value) {
                foreach ($section_value['items'] as $item_key => $item_value) {
                    //$section_list 遍历 
                    $section_list[$section_key]['items'][$item_key]['check_state'] = $check_state[$item_value['exambank_id']];
                    $exampaperlog_score += $check_score[$item_value['exambank_id']];
                    $section_list[$section_key]['items'][$item_key]['check_score'] = $check_score[$item_value['exambank_id']];
                }
            }
            $data = array(
                'exampaperlog_data' => serialize($section_list),
                'exampaperlog_state' => 2, #0未交卷，1已交卷待批改，2已批改
                'exampaperlog_score' => $exampaperlog_score,
            );
            $condition = array(
                'store_id' => 0,
                'exampaperlog_id' => $exampaperlog_id,
            );
            $result = $exampaperlog_model->editExampaperlog($condition, $data);
            if ($result) {
                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }
    //删除..
    public function exampaperlog_drop() {
        $exampaperlog_id = intval(input('param.exampaperlog_id'));
        if (!empty($exampaperlog_id)) {
            $condition = array(
                'exampaperlog_id'=>$exampaperlog_id,
                'store_id'=>0,
            );
            //删除试卷对应的 考试记录
            model('exampaperlog')->delExampaperlog($condition);
            ds_json_encode(10000, lang('ds_common_del_succ'));
        } else {
            ds_json_encode(10001, lang('ds_common_del_fail'));
        }
    }
    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => lang('exampaper_index'),
                'url' => url('exampaper/index')
            ),
            array(
                'name' => 'add',
                'text' => lang('exampaper_add'),
                'url' => "javascript:dsLayerOpen('" . url('exampaper/add') . "','添加题库')"
            ),
        );

        if (request()->action() == 'exampaperlog') {
            $menu_array[] = array(
                'name' => 'exampaperlog',
                'text' => lang('exampaperlog'),
                'url' => "javascript:void(0)"
            );
        }
        
        if (request()->action() == 'config') {
            $menu_array[] = array(
                'name' => 'exampaper_config',
                'text' => lang('exampaper_config'),
                'url' => "javascript:void(0)"
            );
        }
        return $menu_array;
    }

}

?>
