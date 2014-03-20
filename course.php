<?php
//COURSE CLASS
class course
{
	private $dept, $num, $term, $grade, $psid;
	public function __construct($dept, $num, $term, $grade, $psid)
	{
		$this->dept = $dept;
		$this->num = $num;
		$this->term = $term;
		$this->grade = $grade;
		$this->psid = $psid;
	}
	public function setdept($dept)
	{
		$this->dept = $dept;
	}

	public function setnum($num)
	{
		$this->num = $num;
	}

	public function setterm($term)
	{
		$this->term = $term;
	}

	public function setgrade($grade)
	{
		$this->grade = $grade;
	}

	public function setpsid($psid)
	{
		$this->psid = $psid;
	}

	public function getdept()
	{
		return $this->dept;
	}

	public function getnum()
	{
		return $this->num;
	}

	public function getterm()
	{
		return $this->term;
	}

	public function getgrade()
	{
		return $this->grade;
	}

	public function getpsid()
	{
		return $this->psid;
	}

	public function getgpa()
	{
		if(strcmp(rtrim($this->grade), "A+") == 0 || strcmp(rtrim($this->grade), "A") == 0)
			return 4;
		if(strcmp(rtrim($this->grade), "A-") == 0)
			return 3.75;
		if(strcmp(rtrim($this->grade), "B+") == 0)
			return 3.25;
		if(strcmp(rtrim($this->grade), "B") == 0)
			return 3;
		if(strcmp(rtrim($this->grade), "B-") == 0)
			return 2.75;
		if(strcmp(rtrim($this->grade), "C+") == 0)
			return 2.25;
		if(strcmp(rtrim($this->grade), "C") == 0)
			return 2;
		if(strcmp(rtrim($this->grade), "C-") == 0)
			return 1.75;
		if(strcmp(rtrim($this->grade), "D+") == 0)
			return 1.25;
		if(strcmp(rtrim($this->grade), "D") == 0)
			return 1;
		if(strcmp(rtrim($this->grade), "D-") == 0)
			return 0.75;
		if(strcmp(rtrim($this->grade), "F") == 0)
			return 0;
	}
}

?>