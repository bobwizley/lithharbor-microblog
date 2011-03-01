<?php	function get_mostactive_users($force_refresh=FALSE)	{		global $network, $db2, $cache;				if( ! $network->id ) {			return FALSE;		}				$cachekey	= 'n:'.$network->id.',mostactive_userz';		$data	= $cache->get($cachekey);		if( FALSE!==$data && TRUE!=$force_refresh ) {			return $data;		}				$data	= array();		$db2->query('SELECT user_id, COUNT(*) AS c FROM posts WHERE user_id<>0 AND api_id<>2 AND api_id<>6 GROUP BY user_id ORDER BY c DESC LIMIT 10');		while($obj = $db2->fetch_object()) {			$usr = $network->get_user_by_id($obj->user_id);			if( !$usr ){				continue;			}			$data[$obj->user_id]	= array($usr->username, $usr->avatar, $obj->c);		}		$cache->set($cachekey, $data, $GLOBALS['C']->CACHE_EXPIRE);		return $data;	}	function get_mostcommenting_users($force_refresh=FALSE)	{		global $network, $db2, $cache;				if( ! $network->id ) {			return FALSE;		}				$cachekey	= 'n:'.$network->id.',mostcommenting_userz';		$data	= $cache->get($cachekey);		if( FALSE!==$data && TRUE!=$force_refresh ) {			return $data;		}				$data	= array();		$db2->query('SELECT user_id, COUNT(*) AS c FROM posts_comments WHERE user_id<>0 GROUP BY user_id ORDER BY c DESC LIMIT 10');		while($obj = $db2->fetch_object()) {			$usr = $network->get_user_by_id($obj->user_id);			if( !$usr ){				continue;			}			$data[$obj->user_id]	= array($usr->username, $usr->avatar, $obj->c);		}		$cache->set($cachekey, $data, $GLOBALS['C']->CACHE_EXPIRE);		return $data;	}	function get_mostcommented_users($force_refresh=FALSE)	{		global $network, $db2, $cache;				if( ! $network->id ) {			return FALSE;		}				$cachekey	= 'n:'.$network->id.',mostcommented_userz';			$data	= $cache->get($cachekey);		if( FALSE!==$data && TRUE!=$force_refresh ) {			return $data;		}				$data	= array();		$db2->query('SELECT posts.user_id AS uid, COUNT(posts_comments.id) AS c FROM posts, posts_comments WHERE posts.user_id=posts_comments.user_id AND posts_comments.post_id=posts.id AND posts.user_id<>0 AND posts_comments.user_id<>0 GROUP BY posts.user_id ORDER BY c DESC LIMIT 10');		while($obj = $db2->fetch_object()) {			$usr = $network->get_user_by_id($obj->uid);			if( !$usr ){				continue;			}			$data[$obj->uid]	= array($usr->username, $usr->avatar, $obj->c);		}		$cache->set($cachekey, $data, $GLOBALS['C']->CACHE_EXPIRE);		return $data;	}	function get_mostfollowed_users($force_refresh=FALSE)	{		global $network, $db2, $cache;
				if( ! $network->id ) {			return FALSE;		}		$cachekey	= 'n:'.$network->id.',mostfollowed_userz';			$data	= $cache->get($cachekey);		if( FALSE!==$data && TRUE!=$force_refresh ) {			return $data;		}				$data	= array();		$db2->query('SELECT id, username, avatar, num_followers AS c FROM users WHERE num_followers > 0 ORDER BY num_followers DESC LIMIT 10');		while($obj = $db2->fetch_object()) {			if( empty($obj->avatar) ){				$obj->avatar = $GLOBALS['C']->DEF_AVATAR_USER;			}			$data[$obj->id]	= array($obj->username, $obj->avatar, $obj->c);		}		$cache->set($cachekey, $data, $GLOBALS['C']->CACHE_EXPIRE);				return $data;	}	function get_mostfollowing_users($force_refresh=FALSE)	{		global $network, $db2, $cache;
				if( ! $network->id ) {			return FALSE;		}		$cachekey	= 'n:'.$network->id.',mfollowing_userz';			$data	= $cache->get($cachekey);		if( FALSE!==$data && TRUE!=$force_refresh ) {			return $data;		}				$data	= array();		$db2->query('SELECT who, COUNT(*) AS c FROM `users_followed` GROUP BY who ORDER BY `c` DESC LIMIT 10');		while($obj = $db2->fetch_object()) {			$usr = $network->get_user_by_id($obj->who);			if( !$usr ){				continue;			}			$data[$obj->who]	= array($usr->username, $usr->avatar, $obj->c);		}		$cache->set($cachekey, $data, $GLOBALS['C']->CACHE_EXPIRE);				return $data;	}	function get_mostfollowed_groups($force_refresh=FALSE)	{		global $network, $db2, $cache;
				if( ! $network->id ) {			return FALSE;		}				$cachekey	= 'n:'.$network->id.',mostfollowed_groupz';		$data	= $cache->get($cachekey);		if( FALSE!==$data && TRUE!=$force_refresh ) {			return $data;		}				$data	= array();		$db2->query('SELECT id, groupname, avatar, num_followers AS c FROM `groups` WHERE num_followers>0 ORDER BY num_followers DESC LIMIT 10');		while($obj = $db2->fetch_object()) {			if( empty($obj->avatar) ){				$obj->avatar = $GLOBALS['C']->DEF_AVATAR_GROUP;			}			$data[$obj->id]	= array($obj->groupname, $obj->avatar, $obj->c);		}		$cache->set($cachekey, $data, $GLOBALS['C']->CACHE_EXPIRE);				return $data;	}	function get_mostactive_groups($force_refresh=FALSE)	{		global $network, $db2, $cache;
				if( ! $network->id ) {			return FALSE;		}		$cachekey	= 'n:'.$network->id.',mostactive_groupz';		$data	= $cache->get($cachekey);		if( FALSE!==$data && TRUE!=$force_refresh ) {			return $data;		}				$data	= array();		$db2->query('SELECT group_id, COUNT(*) AS c FROM posts WHERE user_id<>0 AND group_id<>0 AND api_id<>2 AND api_id<>6 GROUP BY group_id ORDER BY c DESC LIMIT 10');		while($obj = $db2->fetch_object()) {			$g = $network->get_group_by_id($obj->group_id);			if( !$g ){				continue;			}			$data[$obj->group_id]	= array($g->groupname, $g->avatar, $obj->c);		}		$cache->set($cachekey, $data, $GLOBALS['C']->CACHE_EXPIRE);		return $data;	}	function get_latest_users($force_refresh=FALSE)	{		global $network, $db2, $cache;
				if( ! $network->id ) {			return FALSE;		}		$cachekey	= 'n:'.$network->id.',latest_userz';		$data	= $cache->get($cachekey);		if( FALSE!==$data && TRUE!=$force_refresh ) {			return $data;		}		$data	= array();		$num	= 20;		$db2->query('SELECT id FROM users WHERE active=1 ORDER BY id DESC LIMIT '.$num);		while($obj = $db2->fetch_object()) {			$data[]	= intval($obj->id);		}		$cache->set($cachekey, $data, $GLOBALS['C']->CACHE_EXPIRE);		return $data;	}	function get_saved_searches($force_refresh=FALSE)	{		global $network, $db2, $cache, $user;
				if( ! $user->is_logged ) {			return array();		}			global $C;				$cachekey	= 'n:'.$network->id.',usersavedsearches:'.$user->id;		$data	= $cache->get($cachekey);		if( FALSE!==$data && TRUE!=$force_refresh ) {			return $data;		}			$data = array();		$db2->query('SELECT id, search_key, search_string FROM searches WHERE user_id="'.$user->id.'" ORDER BY id DESC');		while($tmp = $db2->fetch_object()) {			$tmp->search_key		= stripslashes($tmp->search_key);			$tmp->search_string	= stripslashes($tmp->search_string);			$data[$tmp->id]		= $tmp;		}				$cache->set($cachekey, $data, $GLOBALS['C']->CACHE_EXPIRE);		return $data;	}		/*function get_user_by_twitter_username($uname, $force_refresh=FALSE, $return_id=FALSE)
	{
		if( ! $this->id ) {
			return FALSE;
		}
		if( empty($uname) ) {
			return FALSE;
		}
		$cachekey	= 'n:'.$this->id.',twitusername:'.strtolower($uname);
		$uid	= $this->cache->get($cachekey);
		if( FALSE!==$uid && TRUE!=$force_refresh ) {
			return $return_id ? $uid : $this->get_user_by_id($uid);
		}
		$uid	= FALSE;
		$r	= $this->db2->query('SELECT user_id FROM users_details WHERE extrnlusr_twitter="'.$this->db2->escape($uname).'" LIMIT 1', FALSE);
		if( $o = $this->db2->fetch_object($r) ) {
			$uid	= intval($o->user_id);
			$this->cache->set($cachekey, $uid, $GLOBALS['C']->CACHE_EXPIRE);
			return $return_id ? $uid : $this->get_user_by_id($uid);
		}
		$this->cache->del($cachekey);
		return FALSE;
	}*/?>