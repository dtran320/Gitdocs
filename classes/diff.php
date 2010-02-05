<?php

/* ----------------------------------------------------------------------------
 * Diff class
 * Used for passing which changes have been accept or rejected by the user.
 * Gitdocs Jan 2010
 * ---------------------------------------------------------------------------- */

class DiffType {
  const del = "del";
  const ins = "ins";
	const mod = "change";
}

class UserDiffAction {
	const accepted = "accepted";
	const rejected = "rejected";
}

class Diff {
	
	// attributes -- do we care about encapsulation? 
	// i say, let me run with scissors if i want to!
	public $docId;
	public $user;
	public $otherUser;
	public $userAction; 
	public $type;
	public $index;
	
	public function __construct($docId, $user, $otherUser, $userAction, $type, $index){
		$this->docId = $docId;
		$this->user = $user;
		$this->otherUser = $otherUser;
		$this->userAction = $userAction;
		$this->type = $type;
		$this->index = $index;
	}	
}

?>
