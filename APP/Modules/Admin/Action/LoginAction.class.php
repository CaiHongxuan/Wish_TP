<?php
/**
 * 后台登录控制器
 */
Class LoginAction extends Action{
	/**
	 * 登录首页
	 * @return [type] [description]
	 */
	public function index(){
		$this->display();
	}

	/**
	 * 验证码
	 * @return [type] [description]
	 */
	public function verify(){
		import('ORG.Util.Image');
		Image::buildImageVerify(4, 1, 'png', 48, 22);
	}

	/**
	 * 登录
	 * @return [type] [description]
	 */
	public function login(){
		if(!IS_POST) halt('页面不存在');
		if(I('code','','md5') != $_SESSION['verify']){
			$this->error('验证码错误');
		}
		$username = I('username');
		$password = I('password','','md5');
		// $user = M('user')->where(array('username'=>array(eq,$username)))->find();
		$user = M('user')->where(array('username' => $username))->find();
		if(!$user || $password != $user['password']){
			$this->error('帐号或密码错误');
		}
		if($user['locked']){
			$this->error('用户被锁定');
		}

		$data = array(
			'id' => $user['id'],
			'logintime' => time(),
			'loginip' => get_client_ip()
			);
		M('user')->save($data);

		session('uid',$user['id']);
		session('username',$user['username']);
		session('logintime',date('Y-m-d H:i:s',$user['logintime']));
		session('loginip',$user['loginip']);
		$this->redirect('Admin/Index/index');
	}
}