<?php

/**
 * 递归重组节点信息为多维数组
 * @param  [type]  $node [要处理的节点数组]
 * @param  integer $pid  [父级ID]
 * @return [type]        [description]
 */
function node_merge($node, $access = null, $pid = 0){
	$arr = array();
	foreach ($node as $value) {
		if (is_array($access)) {
			$value['access'] = in_array($value['id'], $access) ? 1 : 0;
		}

		if($value['pid'] == $pid){
			$value['child'] = node_merge($node, $access, $value['id']);
			$arr[] = $value;
		}
	}
	return $arr;
}
?>