<?php
/**
 * 后台首页视图控制器
 */
Class IndexAction extends CommonAction{
	/**
	 * 后台首页
	 * @return [type] [description]
	 */
	public function index(){
		$this->display();
	}

	/**
	 * 注销登录
	 * @return [type] [description]
	 */
	public function logout(){
		session_unset();
		session_destroy();
		$this->redirect('Admin/Login/index');
	}
}