<?php
import('persistence.dao.XAbstractEntityCollection');
/**
 * Tutorial
 * 
 * tutorial model class
 * 
 * 新手引导模型定义类
 * 
 * @author Tianwei
 * @package tutorial
 */
class Tutorial extends XAbstractEntityCollection{
	/**
	 * @Save(type=value)
	 */
	protected $items = array();	
	
	public function complete($uid){
		$item = $this->getItem($uid);
		if(!$item){
			return $this;
		}
		$item->setCompleted(true);
		$this->updateItem($item);
		return $this;
	}
}
?>