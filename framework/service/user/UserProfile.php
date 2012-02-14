<?php
import('service.user.AbstractUserProfile');
/**
 * UserProfile
 * 
 * user profile
 * 
 * 用户模型
 * 
 * @Entity
 * @package user
 */
final class UserProfile extends AbstractUserProfile{
	
 	protected $usernameFull;
	protected $usernameShort;
 	
 	protected $imageUrl="";

    public function getUsernameFull(){
    	return $this->get('usernameFull');
    }
    
    public function setUsernameFull($usernameFull){
    	$this->set('usernameFull', $usernameFull);
    }

    public function getUsernameShort(){
    	return $this->get('usernameShort');
    }
    
    public function setUsernameShort($usernameShort){
    	$this->set('usernameShort', $usernameShort);
    }

    public function getImageUrl(){
    	return $this->get('imageUrl');
    }
    
    public function setImageUrl($imageUrl){
    	$this->set('imageUrl', $imageUrl);
    }
}
?>