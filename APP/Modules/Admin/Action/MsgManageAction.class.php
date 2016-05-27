<?php
/**
 * 帖子管理控制器
 */
Class MsgManageAction extends CommonAction{
	/**
	 * 查看所有帖子
	 * @return [type] [description]
	 */
	public function index(){
		import('ORG.Util.Page');

		$count = M('wish')->count();
		$page = new Page($count,10);

		$limit = $page->firstRow . ',' . $page->listRows;
		$wish = M('wish')->order('time DESC')->limit($limit)->select();
		
		$this->page = $page->show();
		$this->wish = $wish;
		$this->display();
	}

	/**
	 * 删除帖子
	 * @return [type] [description]
	 */
	public function delete(){
		$id = I('id','','intval');
		// M('wish')->where(array('id'=>$id))->delete();
		if(M('wish')->delete($id)){
			$this->success('删除成功',U('Admin/MsgManage/index'));
		}else{
			$this->error('删除失败');
		}
	}
}