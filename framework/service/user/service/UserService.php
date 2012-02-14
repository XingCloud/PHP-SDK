<?php
/**
 * UserService
 * 
 * user service
 * 
 * 用户服务
 * 
 * @Pointcut('protocol|auth')
 * @author Tianwei
 * @package user
 */
class UserService extends XAbstractService{
	/**
	 * <b>platform user login service, return the user information</b>
	 * 
	 * <b>平台用户登录服务，返回用户信息。</b>
	 * 
	 * <b>参数要提供SNS平台的APP ID和用户在SNS平台的用户ID。</b>
	 * 
	 * @Protocol(allow='ANY')
	 * @Method(allow='POST')
	 * @Auth(type='http')
	 * @param XServiceRequest $request 服务请求
	 * @return XServiceResult
	 */
	public function doPlatformLogin(XServiceRequest $request){
		import('service.user.UserFactory');
		$user = UserFactory::singleton()->platformLogin($request);
		return $this->_success($user);
	}
	
	/**
	 * <b>platform user register service, create user profile in Database when user first login</b>
	 * 
	 * <b>平台用户注册服务，用户首次登陆时在数据库中创建用户记录。</b>
	 * 
	 * <b>参数要提供SNS平台的ID和用户在SNS平台的用户ID。</b>
	 * 
	 * @Protocol(allow='ANY')
	 * @Method(allow='POST')
	 * @Auth(type='http')
	 * @param XServiceRequest $request 服务请求
	 * @ServiceParam array userinfo 用户属性初始化值
	 * @return XServiceResult
	 */
	public function doPlatformRegister(XServiceRequest $request){
		import('service.user.UserFactory');
		$user = UserFactory::singleton()->platformRegister($request);
		return $this->_success($user);
	}
	
	/**
	 * <b>user login service, return the user information</b>
	 * 
	 * <b>用户登录服务，返回用户信息。</b>
	 * 
	 * <b>参数要提供用户名和用户密码。</b>
	 * 
	 * @Protocol(allow='ANY')
	 * @Method(allow='POST')
	 * @Auth(type='http')
	 * @param XServiceRequest $request 服务请求
	 * @ServiceParam string username 用户名
	 * @ServiceParam string password 用户密码
	 * @return XServiceResult
	 */
	public function doLogin(XServiceRequest $request){
		import('service.user.UserFactory');
		$user = UserFactory::singleton()->login($request);
		return $this->_success($user);
	}
	
	/**
	 * <b>user register service, create user profile in Database when user first login</b>
	 * 
	 * <b>用户注册服务，用户首次登陆时在数据库中创建用户记录。</b>
	 * 
	 * <b>参数要提供用户名和用户密码。</b>
	 * 
	 * @Protocol(allow='ANY')
	 * @Method(allow='POST')
	 * @Auth(type='http')
	 * @param XServiceRequest $request 服务请求
	 * @ServiceParam array account 用户账户属性初始化值,必须指定username&password
	 * @return XServiceResult
	 */
	public function doRegister(XServiceRequest $request){
		import('service.user.UserFactory');
		$user = UserFactory::singleton()->register($request);
		return $this->_success();
	}
	
	/**
	 * <b>bind platform service, bind a group of platformAppId & platformUserId to a user account</b>
	 * 
	 * <b>绑定平台服务，将一组SNS平台APP ID和用户在SNS平台的ID绑定到一个用户账号上。</b>
	 * 
	 * <b>参数要提供SNS平台的APP ID和用户在SNS平台的用户ID。</b>
	 * 
	 * @Protocol(allow='ANY')
	 * @Method(allow='POST')
	 * @Auth(type='http')
	 * @param XServiceRequest $request 服务请求
	 * @return XServiceResult
	 */
	public function doBindPlatform(XServiceRequest $request){
		import('service.user.UserFactory');
		$result = UserFactory::singleton()->bindPlatform($request);
		return $this->_success($result);
	}
	
	/**
	 * <b>load user information by gameUserId or platformAppId&platformUserId</b>
	 * 
	 * <b>获取用户信息的服务，返回用户信息。</b>
	 * 
	 * <b>参数要提供用户在游戏内部的UID(gameUserId)或用户平台信息(platformAppId&platformUserId)。</b>
	 * 
	 * @Protocol(allow='ANY')
	 * @Method(allow='ANY')
	 * @Auth(type='http')
	 * @param XServiceRequest $request 服务请求
	 * @return XServiceResult
	 */
	public function doGet(XServiceRequest $request){
		$data = $request->getData();
		$gameUserIds = array();
		$platforAddresses = array();
		if(!empty($data)){
			foreach ($data as $value){
				if(is_array($value)){
					if(array_key_exists('gameUserId', $value)){
						$gameUserIds[] = $value['gameUserId'];
					}elseif(array_key_exists('platformAppId', $value) && array_key_exists('platformUserId', $value)){
						$platforAddresses[] = $value['platformUserId'].'_'.$value['platformAppId'];
					}
				}
			}
		}
		$profileList1 = array();
		$profileList2 = array();
		if(!empty($platforAddresses)){
			import('service.user.UserFactory');
			$profileList1 = UserFactory::singleton()->getUsersByPlatformAddresses($platforAddresses);
		}
		if(!empty($gameUserIds)){
			import('service.user.UserFactory');
			$profileList2 = UserFactory::singleton()->getUsers($gameUserIds);
		}
		$profileList = array_merge($profileList1, $profileList2);
		return $this->_success(array_values($profileList));
	}
}
?>
