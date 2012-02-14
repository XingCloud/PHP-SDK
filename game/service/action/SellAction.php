<?php
/** 
 * @Pointcut('lock')
 * @Lock(policy='retrieve')
 * @package action
 */
class SellAction extends XAbstractAction{	
	protected function execute(XActionRequest $request){
		return new XServiceResult();
	}
}
?>