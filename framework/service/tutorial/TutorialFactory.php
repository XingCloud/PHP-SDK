<?php
/**
 * TutorialFactory
 * 
 * tutorial factory class
 * 
 * 新手引导工厂类
 * 
 * @author Tianwei
 * @package tutorial
 */
class TutorialFactory{
	/** 
	 * <b>query a tutorial by given uid</b>
	 * 
	 * <b>根据给定的uid对新手引导进行查询，并返回结果</b>
	 * 
	 * @return Tutorial
	 */
	public static function get($uid){
		import('service.tutorial.Tutorial');
		import('service.tutorial.TutorialStep');
		import('persistence.orm.PersistenceSession');
		$tutorial = PersistenceSession::singleton()->get('Tutorial', $uid);
		if(!$tutorial){
			$tutorial = new Tutorial();
			$tutorial->set('uid', $uid);
			$tutorial->save();
		}
		return $tutorial;
	}

	/** 
	 * <b>create a tutorial step by the given tutorial name, step name and step index</b>
	 * 
	 * <b>根据给定的新手引导名、步骤名、步骤索引来创建一个新手引导步骤</b>
	 * 
	 * @return TutorialStep
	 */
	public static function createStep(XServiceRequest $request){
		import('service.tutorial.Tutorial');
		import('service.tutorial.TutorialStep');
		$step = new TutorialStep();
		$step->setTutorial($request->getParameter('tutorial'));
		$step->setName($request->getParameter('name'));
		$step->setIndex($request->getParameter('index'));
		return $step;
	}
}
?>