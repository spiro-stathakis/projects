<?php

namespace common\components; 


class LdapComponent extends \common\components\XComponent
{
	
		 private $_ldapCnx;
		 private $_resultFields=array("dn","cn","ou","mail","sn","fullname","givenname","uidnumber","gidnumber","uid","telephoneNumber","messageserver","homedirectory","loginshell");
		 private $_host = "ldaps://ldap-jccs.cf.ac.uk";
		 private $_baseDn ="";
		 private $filter="((uid=%s))";
		 // private $_baseDn ="o=cf";
		/* #################################################################### */
		public function __construct(){
			 
			if ( ($this->_ldapCnx=ldap_connect($this->_host) ) === FALSE )
				throw new CException(sprintf('Cannot connect to ldap host: %s' , $this->_host));

			ldap_set_option ($this->_ldapCnx, LDAP_OPT_REFERRALS, 0);
			ldap_set_option($this->_ldapCnx, LDAP_OPT_PROTOCOL_VERSION, 3);
		}
		/* #################################################################### */
		public function login($username,$password)
		{
				$dn = $this->_getLdapDn($username); 
				return $this->_bind($dn, $password); 
		}
		/* #################################################################### */

		public function getResultData()
		{
			return $this->_resultData; 
		}
		/* #################################################################### */
		private function _bind($dn,$pass){
			
			return @ldap_bind($this->_ldapCnx,$dn,$pass);
		}
		/* #################################################################### */
		private function _getLdapDn($user){
			
			$s =  sprintf("uid=%s", $user); 
			$search = $this->search($s);
			if ($search['count'] > 0)
				return $search['data'][0]["dn"]; 
				
			return false; 
		} 

		/* #################################################################### */
		public function userSearch($username)
		{
			return $this->_getLdapDn($username);
		}
		/* #################################################################### */ 
		public function groupSearch($s){
					$statement = sprintf('(&(objectClass=group)(cn=%s))',$s);
					$_search =ldap_search($this->_ldapCnx,$this->_baseDn,$statement,['uniquemember']);
					$_arr=  ldap_get_entries($this->_ldapCnx,$_search); 
					$_arr = $_arr[0]['uniquemember']; 
					$ret = []; 
					foreach ($_arr as $k=>$v)
						if ($k !== 'count')
							$ret[] = $v; 

					return $ret; 

		} 
		/* #################################################################### */ 

		public function search($statement){  //returns false if there is a problem
			
			$results = array(); 
			$_search = ldap_search($this->_ldapCnx,$this->_baseDn,$statement,$this->_resultFields);
			$results['data'] = ldap_get_entries($this->_ldapCnx,$_search); 
			$results['count'] =ldap_count_entries($this->_ldapCnx, $_search); 
			return $results;
			
		} 
/* #################################################################### */
} // end class 


