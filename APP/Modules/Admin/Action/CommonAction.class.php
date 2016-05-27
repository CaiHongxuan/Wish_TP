<?php
Class CommonAction extends Action{
	public function _initialize(){
		if(!isset($_SESSION['uid']) || !isset($_SESSION['username'])){
			$this->redirect('Admin/Login/index');
		}
	}
	public function index(){
		$this->redirect('Admin/Index/index');
	}
}
?>