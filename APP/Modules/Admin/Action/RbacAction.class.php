<?php
Class RbacAction extends CommonAction{
	/**
	 * 用户列表
	 * @return [type] [description]
	 */
	public function index(){
		$this->user = M('user')->select();
		$this->display();
	}

	/**
	 * 角色列表
	 * @return [type] [description]
	 */
	public function role(){
		// $this->assign('role', M('role')->select());
		$this->role = M('role')->select();
		$this->display();
	}

	/**
	 * 节点列表
	 * @return [type] [description]
	 */
	public function node(){
		$field = array('id','name','title','pid');
		$node = M('node')->field($field)->order('sort')->select();
		$this->node = node_merge($node);
		$this->display();
	}

	/**
	 * 添加用户
	 */
	public function addUser(){
		$this->role = M('role')->select();
		$this->display();
	}

	/**
	 * 添加用户表单处理
	 */
	public function addUserHandle(){
		$user = array(
			'username' => I('username'),
			'password' => I('password', '', 'md5'),
			'logintime' => time(),
			'loginip' => get_client_ip()
			);
		// 添加用户
		$role = array();
		if($uid = M('user')->add($user)){
			foreach ($_POST['role_id'] as $value) {
				if($value == 0)
					continue;
				// 所属角色
				$role[] = array(
					'role_id' => $value,
					'user_id' => $uid
					);
			}
			M('role_user')->addAll($role);
			$this->success("添加成功",U('Admin/Rbac/index'));
		}else{
			$this->error("添加失败");
		}
	}

	/**
	 * 删除用户
	 * @return [type] [description]
	 */
	public function deleteUser(){
		$id = I('id','','intval');
		if(M('user')->where(array('id' => $id))->delete()){
			$this->success('删除成功',U('Admin/Rbac/index'));
		}else{
			$this->error('删除失败');
		}
	}

	/**
	 * 添加角色
	 */
	public function addRole(){
		$this->display();
	}

	/**
	 * 添加角色表单处理
	 */
	public function addRoleHandle(){
		if(!IS_POST) halt("页面不存在");
		if(M('role')->data($_POST)->add()){
			$this->success('添加成功', U('Admin/Rbac/role'));
		}else{
			$this->error('添加失败');
		}
	}

	/**
	 * 添加节点
	 */
	public function addNode(){
		$this->pid = I('pid',0,'intval');
		$this->level = I('level',1,'intval');
		switch ($this->level) {
			case 1:
				$this->type = '应用';
				break;
			case 2:
				$this->type = '控制器';
				break;
			case 3:
				$this->type = '方法';
				break;
			default:
				$this->type = '应用';
				break;
		}
		$this->display();
	}

	/**
	 * 添加节点表单处理
	 */
	public function addNodeHandle(){
		if(!IS_POST) halt("页面不存在");
		if(M('node')->add($_POST)){
			$this->success('添加成功',U('Admin/Rbac/node'));
		}else{
			$this->error("添加失败");
		}
	}

	/**
	 * 权限列表
	 * @return [type] [description]
	 */
	public function access(){
		$this->rid = I('rid',0,'intval');

		$node = M('node')->order('sort')->select();
		$access = M('access')->where(array('role_id' => $this->rid))->getField('node_id', true);

		$this->node = node_merge($node, $access);
		$this->display();
	}

	/**
	 * 配置权限
	 */
	public function setAccess(){
		if(!IS_POST) halt("页面不存在");

		$rid = I('rid',0,'intval');
		$db = M('access');
		// 清空之前的记录
		$db->where(array('role_id' => $rid))->delete();

		$data = array();
		foreach ($_POST['access'] as $v) {
			$tmp = explode('_', $v);
			$data[] = array(
				'role_id' => $rid,
				'node_id' => $tmp[0],
				'level' => $tmp[1]
				);
		}
		// 添加权限
		if($db->addAll($data)){
			$this->success('修改成功',U('Admin/Rbac/role'));
		}else{
			$this->error('修改失败');
		}
	}

}
?>