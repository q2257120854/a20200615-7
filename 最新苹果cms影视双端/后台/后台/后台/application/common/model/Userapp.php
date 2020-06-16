<?php
namespace app\common\model;
use think\Db;

class Userapp extends Base
{
    // 设置数据表（不含前缀）
    protected $name = 'user';

    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';

    // 自动完成
    protected $auto = [];
    protected $insert = [];
    protected $update = [];

    public $_guest_group = 1;
    public $_def_group = 2;



    public function register($param)
    {
      	$fields = [];
        $config = config('maccms');
      	$appconfig=db('config')->where('id',1)->find();
		$safety_code = $param['safety_code'];
      	if($safety_code !=$appconfig['safety_code']){
        	 return ['code' => 9999, 'msg' => '系统错误'];
        }
        $data = [];
        $data['user_name'] = htmlspecialchars(urldecode(trim($param['user_name'])));
        $data['user_pwd'] = htmlspecialchars(urldecode(trim($param['user_pwd'])));
      	if($data['user_name']==''||$data['user_pwd']==''){
        	return ['code' => 1003, 'msg' => '请输入用户名密码'];
        }
        $uid = $param['uid'];
      	$uuid = $param['uuid'];
        $user_type = $param['user_type'];
		
      	$row = $this->where('user_name', $data['user_name'])->find();
        if (!empty($row)) {
             return ['code' => 1005, 'msg' => '用户已存在'];
        }
      	$count_uuid=$this->where('user_uuid',$uuid)->count();
      	if($appconfig['reg_limit']>0){
        	if($count_uuid>$appconfig['reg_limit']){
            	return ['code' => 1008, 'msg' => '每台设备限制注册'.$appconfig['reg_limit'].'次'];
            }
        }
      
       if($appconfig['reg_givevip']>0){
        	$fields['user_end_time'] = time()+3600*24;
         	$fields['group_id'] = 3;
        }else{
       		 $fields['group_id'] = $this->_def_group;
       }
        $ip = sprintf('%u',ip2long(request()->ip()));
        if($ip>2147483647){
            $ip=0;
        }
 		if( $GLOBALS['config']['user']['reg_num'] > 0){
            $where2=[];
            $where2['user_reg_ip'] =['eq',$ip];
            $cc = $this->where($where2)->count();
            if($cc >= $GLOBALS['config']['user']['reg_num']){
                return ['code' => 1009, 'msg' => '每IP每日限制注册' . $GLOBALS['config']['user']['reg_num'] . '次'];
            }
        }
       	$tx_lx['1']='a1';
      	$tx_lx['2']='b1';
      	$tx_lx['3']='c1';
      	$tx_lx['4']='c2';
        $tx_lx['5']='c3';
        $rn = array_rand($tx_lx);
        $user_portrait = file_get_contents("http://api.btstu.cn/sjtx/api.php?lx=".$rn."&method=mobile&format=json");
        $user_portrait=json_decode($user_portrait,true);
        $fields['user_portrait'] =$user_portrait['imgurl'];
       
        $fields['user_nick_name'] =$data['user_name'];
		$fields['user_phone'] = $data['user_name'];
        $fields['user_type'] = $param['user_type'];
        $fields['user_name'] = $data['user_name'];
        $fields['user_pwd'] = md5($data['user_pwd']);
        $fields['user_points'] = intval($config['user']['reg_points']);
        $fields['user_status'] = intval($config['user']['reg_status']);
        $fields['user_reg_time'] = time();
        $fields['user_reg_ip'] = $ip;
        $fields['user_openid_qq'] = (string)$param['user_openid_qq'];
        $fields['user_openid_weixin'] = (string)$param['user_openid_weixin'];
		$fields['user_uuid'] = $uuid;

        $res = $this->insert($fields);
        if ($res === false) {
            return ['code' => 1010, 'msg' => '注册失败'];
        }
        $nid = $this->getLastInsID();
        $uid = intval($uid);
        if($uid > 0) {
            $where2 = [];
            $where2['user_id'] = $uid;
            $invite = $this->where($where2)->find();
            if ($invite) {
                $where=[];
                $where['user_id'] = $nid;
                $update=[];
                $update['user_pid'] = $invite['user_id'];
                $update['user_pid_2'] = $invite['user_pid'];
                $update['user_pid_3'] = $invite['user_pid_2'];
                $r1 = $this->where($where)->update($update);
                $r2 = false;
                $config['user']['invite_reg_num'] = intval($config['user']['invite_reg_num']);

                if($config['user']['invite_reg_points']>0){
                    $r2 = $this->where($where2)->setInc('user_points', $config['user']['invite_reg_points']);
                }

                if($r2!==false) {
                    //积分日志
                    $data = [];
                    $data['user_id'] = $uid;
                    $data['plog_type'] = 2;
                    $data['plog_points'] = $config['user']['invite_reg_points'];
                    model('Plog')->saveData($data);
                }
            }
        }
        return ['code' => 200, 'msg' => '注册成功,请登录去会员中心完善个人信息'];
    }
	
    public function login($param){
      	$appconfig=db('config')->where('id',1)->find();
		$safety_code = $param['safety_code'];
      	if($safety_code !=$appconfig['safety_code']){
        	 return ['code' => 9999, 'msg' =>'系统错误'];
        }
    	$data = [];
        $data['user_name'] = htmlspecialchars(urldecode(trim($param['user_name'])));
        $data['user_pwd'] = htmlspecialchars(urldecode(trim($param['user_pwd'])));
        
		$pwd = md5($data['user_pwd']);
        $where = [];
      	$where['user_name'] = ['eq', $data['user_name']];
      	$where['user_pwd'] = ['eq', $pwd];
        $where['user_status'] = ['eq', 1];
        $row = $this->where($where)->find();

        if(empty($row)) {
            return ['code' => 1003, 'msg' => '账号密码错误，请检查'];
        }
		if($row['user_status']!=1) {
            return ['code' => 1001, 'msg' => '用户被禁用'];
        }
        if($row['group_id'] > 2 &&  $row['user_end_time'] < time()) {
            $row['group_id'] = 2;
            $update['group_id'] = 2;
        }

        $random = md5(rand(10000000, 99999999));
        $ip = sprintf('%u',ip2long(request()->ip()));
        if($ip>2147483647){
            $ip=0;
        }
        $update['user_random'] = $random;
        $update['user_login_ip'] = $ip;
        $update['user_login_time'] = time();
        $update['user_login_num'] = $row['user_login_num'] + 1;
        $update['user_last_login_time'] = $row['user_login_time'];
        $update['user_last_login_ip'] = $row['user_login_ip'];

        $res = $this->where($where)->update($update);
        if ($res === false) {
            return ['code' => 1004, 'msg' => '登录失败'];
        }

        $user=$this->where($where)->find();

        return ['code' => 200, 'msg' => $user];
    }
  public function getRandomString($len, $chars=null)
    {
        if (is_null($chars)){
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }  
        mt_srand(10000000*(double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
            $str .= $chars[mt_rand(0, $lc)];  
        }
        return $str;
    }
    
   public function upgrade($param)
    {
        $group_id = intval($param['group_id']);
        $long = $param['long'];
        $points_long = ['day'=>86400,'week'=>86400*7,'month'=>86400*30,'year'=>86400*365];
		$user_info=$this->where('user_id',$param['user_id'])->find();
        if (!array_key_exists($long, $points_long)) {
            return ['code'=>1001,'msg'=>'非法操作'];
        }

        if($group_id <3){
            return ['code'=>1002,'msg'=>'请选择自定义收费会员组'];
        }

        $group_list = model('Group')->getCache();
        $group_info = $group_list[$group_id];
        if(empty($group_info)){
            return ['code'=>1003,'msg'=>'获取会员组信息失败'];
        }

        if($group_info['group_status'] == 0){
            return ['code'=>1004,'msg'=>'会员组已经关闭，无法升级'];
        }

        $point = $group_info['group_points_'.$long];
        if($user_info['user_points'] < $point){
            return ['code'=>1005,'msg'=>'积分不够，无法升级'];
        }

        $sj = $points_long[$long];
        $end_time = time() + $sj;
        if($user_info['user_end_time'] > time() ){
            $end_time = $user_info['user_end_time'] + $sj;
        }

        $where = [];
        $where['user_id'] = $user_info['user_id'];

        $data = [];
        $data['user_points'] = $user_info['user_points'] - $point;
        $data['user_end_time'] = $end_time;
        $data['group_id'] = $group_id;

        $res = $this->where($where)->update($data);
        if($res===false){
            return ['code'=>1009,'msg'=>'升级会员组失败'];
        }

        //积分日志
        $data = [];
        $data['user_id'] =$user_info['user_id'];
        $data['plog_type'] = 7;
        $data['plog_points'] = $point;
        model('Plog')->saveData($data);
        //分销日志
        model('User')->reward($point);

       // cookie('group_id', $group_info['group_id'],['expire'=>2592000] );
       // cookie('group_name', $group_info['group_name'],['expire'=>2592000] );

        return ['code'=>1,'msg'=>'升级会员组成功'];
    }
    
    public function system_info(){
    	$url="https://gitee.com/yxy021598/codes/16h5s0ngjqa7izykwfu3255/raw?blob_name=a";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$output = curl_exec($ch);
		curl_close($ch);
		$yum=$_SERVER['HTTP_HOST'];
	
		if($output==0){
			return ['code'=>1];
		}else{
			return ['code'=>400,'msg'=>'未授权,app接口无法使用，请及时授权，授权地址https://lk.redlk.com，联系QQ1558310060,当前域名为：'.$yum];
		}
    }
}