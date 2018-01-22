<?php

	class ACL
	{
		var $perms = array();		//Array : Stores the permissions for the user
		var $userID = 0;			//Integer : Stores the ID of the current user
		var $userRoles = array();	//Array : Stores the roles of the current user
		var $link = null;			//NULL : Stores the connection object of the bbdd

		function __construct($userID = '')
		{	
			// Connection object of the BBDD
			$link = mysqli_connect('localhost','root','');
			if ($link->connect_error != null) {   
				die("Could not connect to the MySQL server at localhost.");
			} else {
				mysqli_select_db($link, 'acl_test');
				$this->link = $link;
			}

			if ($userID != '')
			{
				$this->userID = floatval($userID);
			} else {
				$this->userID = floatval($_SESSION['userID']);
			}
			$this->userRoles = $this->getUserRoles('ids');
			$this->buildACL();
		}
		
		// function ACL($userID = '')
		// {
		// 	$this->__constructor($userID);
		// 	//crutch for PHP4 setups
		// }
		
		function buildACL()
		{
			//first, get the rules for the user's role
			if (count($this->userRoles) > 0)
			{
				$this->perms = array_merge($this->perms,$this->getRolePerms($this->userRoles));
			}
			//then, get the individual user permissions
			$this->perms = array_merge($this->perms,$this->getUserPerms($this->userID));
		}
		
		function getPermKeyFromID($permID)
		{
			$strSQL = "SELECT `permKey` FROM `permissions` WHERE `ID` = " . floatval($permID) . " LIMIT 1";
			$data = mysqli_query($this->link, $strSQL);
			$row = mysqli_fetch_array($data);
			return $row[0];
		}
		
		function getPermNameFromID($permID)
		{
			$strSQL = "SELECT `permName` FROM `permissions` WHERE `ID` = " . floatval($permID) . " LIMIT 1";
			$data = mysqli_query($this->link, $strSQL);
			$row = mysqli_fetch_array($data);
			return $row[0];
		}
		
		function getRoleNameFromID($roleID)
		{
			$strSQL = "SELECT `roleName` FROM `roles` WHERE `ID` = " . floatval($roleID) . " LIMIT 1";
			$data = mysqli_query($this->link, $strSQL);
			$row = mysqli_fetch_array($data);
			return $row[0];
		}
		
		function getUserRoles()
		{
			$strSQL = "SELECT * FROM `user_roles` WHERE `userID` = " . floatval($this->userID);
			$data = mysqli_query($this->link, $strSQL);
			$resp = array();
			while($row = mysqli_fetch_array($data))
			{
				$resp[] = $row['roleID'];
			}
			return $resp;
		}
		
		function getAllRoles($format='ids')
		{
			$format = strtolower($format);
			$strSQL = "SELECT * FROM `roles` ORDER BY `roleName` ASC";
			$data = mysqli_query($this->link, $strSQL);
			$resp = array();
			while($row = mysqli_fetch_array($data))
			{
				if ($format == 'full')
				{
					$resp[] = array("ID" => $row['ID'],"Name" => $row['roleName']);
				} else {
					$resp[] = $row['ID'];
				}
			}
			return $resp;
		}
		
		function getAllPerms($format='ids')
		{
			$format = strtolower($format);
			$strSQL = "SELECT * FROM `permissions` ORDER BY `permName` ASC";
			$data = mysqli_query($this->link, $strSQL);
			$resp = array();
			while($row = mysqli_fetch_assoc($data))
			{
				if ($format == 'full')
				{
					$resp[$row['permKey']] = array('ID' => $row['ID'], 'Name' => $row['permName'], 'Key' => $row['permKey']);
				} else {
					$resp[] = $row['ID'];
				}
			}
			return $resp;
		}

		function getRolePerms($role)
		{
			if (is_array($role))
			{
				$roleSQL = "SELECT * FROM `role_perms` WHERE `roleID` IN (" . implode(",",$role) . ") ORDER BY `ID` ASC";
			} else {
				$roleSQL = "SELECT * FROM `role_perms` WHERE `roleID` = " . floatval($role) . " ORDER BY `ID` ASC";
			}
			$data = mysqli_query($this->link, $roleSQL);
			$perms = array();
			while($row = mysqli_fetch_assoc($data))
			{
				$pK = strtolower($this->getPermKeyFromID($row['permID']));
				if ($pK == '') { continue; }
				if ($row['value'] === '1') {
					$hP = true;
				} else {
					$hP = false;
				}
				$perms[$pK] = array('perm' => $pK,'inheritted' => true,'value' => $hP,'Name' => $this->getPermNameFromID($row['permID']),'ID' => $row['permID']);
			}
			return $perms;
		}
		
		function getUserPerms($userID)
		{
			$strSQL = "SELECT * FROM `user_perms` WHERE `userID` = " . floatval($userID) . " ORDER BY `addDate` ASC";
			$data = mysqli_query($this->link, $strSQL);
			$perms = array();
			while($row = mysqli_fetch_assoc($data))
			{
				$pK = strtolower($this->getPermKeyFromID($row['permID']));
				if ($pK == '') { continue; }
				if ($row['value'] == '1') {
					$hP = true;
				} else {
					$hP = false;
				}
				$perms[$pK] = array('perm' => $pK,'inheritted' => false,'value' => $hP,'Name' => $this->getPermNameFromID($row['permID']),'ID' => $row['permID']);
			}
			return $perms;
		}
		
		function userHasRole($roleID)
		{
			foreach($this->userRoles as $k => $v)
			{
				if (floatval($v) === floatval($roleID))
				{
					return true;
				}
			}
			return false;
		}
		
		function hasPermission($permKey)
		{
			$permKey = strtolower($permKey);
			if (array_key_exists($permKey,$this->perms))
			{
				if ($this->perms[$permKey]['value'] === '1' || $this->perms[$permKey]['value'] === true)
				{
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
		
		function getUsername($userID)
		{
			$strSQL = "SELECT `username` FROM `users` WHERE `ID` = " . floatval($userID) . " LIMIT 1";
			$data = mysqli_query($this->link, $strSQL);
			$row = mysqli_fetch_array($data);
			return $row[0];
		}
	}

?>