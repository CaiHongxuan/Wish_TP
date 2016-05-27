<?php
/**
 * 前台首页视图控制器
 */
Class IndexAction extends Action{
	/**
	 * 首页显示
	 * @return [type] [description]
	 */
	public function index () {
		$this->assign('wish',M('wish')->select())->display();
	}

	/**
	 * 异步表单发布处理
	 * @return [type] [description]
	 */
	public function handle(){
		if(! IS_AJAX) halt("页面不存在");
		$data = array(
			'username' => I('username'),
			'content' => I('content'),
			'time' => time()
			);

		// $phiz = array(
		// 	'zhuakuang' => '抓狂',
		// 	'baobao' => '抱抱',
		// 	'haixiu.gif' => '害羞',
		// 	'ku.gif' => '酷',
		// 	'xixi.gif' => '嘻嘻',
		// 	'taikaixin' => '太开心',
		// 	'touxiao' => '偷笑',
		// 	'qian' => '钱',
		// 	'huaxin' => '花心',
		// 	'jiyan' => '挤眼'
		// 	);
		/*$str = '<?php return ' . var_export($phiz, true) . '; ?>';
		file_put_contents('./Data/phiz.php', $str);*/

		// F('phiz', $phiz, './Data/');

		if($id = M('wish')->data($data)->add()){
			$data['id'] = $id;
			$data['content'] = replace_phiz($data['content']);
			$data['time'] = date('Y-m-d H:i', $data['time']);
			$data['status'] = 1;
			$this->ajaxReturn($data, 'json');
		}else{
			$this->ajaxReturn(array('status' => 0), 'json');
		}
	}
}