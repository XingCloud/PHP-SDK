<?php
/** 
 * @Pointcut('lock')
 * @Lock(policy='retrieve')
 * @package action
 */
class BuyAction extends XAbstractAction{
	protected function execute(XActionRequest $request){
		return XServiceResult::success();
	}
}
?>