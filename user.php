<?php
//USER CLASS
class user
{
	private $id, $pw, $uname, $email, $lname, $fname, $alevel;
	public function __construct($id, $pw, $uname, $email, $lname, $fname, $alevel)
	{
		$this->id = $id;
		$this->pw = $pw;
		$this->uname = $uname;
		$this->email = $email;
		$this->lname = $lname;
		$this->fname = $fname;
		$this->alevel = $alevel;
	}
	public function setid($id)
	{
		$this->id = $id;
	}

	public function setpw($pw)
	{
		$this->pw = $pw;
	}

	public function setuname($uname)
	{
		$this->uname = $uname;
	}

	public function setemail($email)
	{
		$this->email = $email;
	}

	public function setlname($lname)
	{
		$this->lname = $lname;
	}

	public function setfname($fname)
	{
		$this->fname = $fname;
	}

	public function setalevel($alevel)
	{
		$this->alevel = $alevel;
	}

	public function getid()
	{
		return $this->id;
	}

	public function getpw()
	{
		return $this->pw;
	}

	public function getuname()
	{
		return $this->uname;
	}

	public function getemail()
	{
		return $this->email;
	}

	public function getlname()
	{
		return $this->lname;
	}

	public function getfname()
	{
		return $this->fname;
	}

	public function getalevel()
	{
		return $this->alevel;
	}
}

?>