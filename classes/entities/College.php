<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/02/18
 * Time: 02:20
 */

class College{
	private $collegeName;
	/**
	 * The type of education the college offers
	 * "2-year", "4-year", "vocational", "online", "Grad School"
	 * @var $collegeType
	 */
	private $collegeType;
	private $collegeStreetAddress;
	private $collegeCity;
	/**
	 * Foreign key referencing pkStateID in tblProvince. Refers to the province or state in which the college is located
	 * @var $provinceID
	 */
	private $provinceID;
	private $collegeZip;
	/**
	 * Phone number of the College used as contact information.
	 * Does not include the country code (this information garnered through the fkProvinceID field).
	 * @var
	 */
	private $collegePhone;
	/**
	 * The average yearly tutition for the college in state
	 * @var
	 */
	private $collegeInStateTuition;
	/**
	 * The average yearly tuition for the college out of state
	 * @var $collegeOutStateTuition
	 */
	private $collegeOutStateTuition;
	/**
	 * The average amount of financial aid given to students
	 * @var $collegeFinancialAverage
	 */
	private $collegeFinancialAverage;
	/**
	 * The average rate of student acceptance at the college
	 * @var $collegeAcceptRate
	 */
	private $collegeAcceptRate;

	/**
	 * College constructor.
	 * @param $collegeName
	 * @param $collegeType
	 * @param $collegeStreetAddress
	 * @param $collegeCity
	 * @param $provinceID
	 * @param $collegeZip
	 * @param $collegePhone
	 * @param $collegeInStateTuition
	 * @param $collegeOutStateTuition
	 * @param $collegeFinancialAverage
	 * @param $collegeAcceptRate
	 * @param $collegeProfessorCount
	 * @param $collegeSize
	 * @param $collegeWomanRatio
	 * @param $collegeACT
	 * @param $collegeSAT
	 * @param $collegeSetting
	 */
	public function __construct($collegeName, $collegeType, $collegeStreetAddress, $collegeCity, $provinceID, $collegeZip, $collegePhone, $collegeInStateTuition, $collegeOutStateTuition, $collegeFinancialAverage, $collegeAcceptRate, $collegeProfessorCount, $collegeSize, $collegeWomanRatio, $collegeACT, $collegeSAT, $collegeSetting){
		$this->collegeName = $collegeName;
		$this->collegeType = $collegeType;
		$this->collegeStreetAddress = $collegeStreetAddress;
		$this->collegeCity = $collegeCity;
		$this->provinceID = $provinceID;
		$this->collegeZip = $collegeZip;
		$this->collegePhone = $collegePhone;
		$this->collegeInStateTuition = $collegeInStateTuition;
		$this->collegeOutStateTuition = $collegeOutStateTuition;
		$this->collegeFinancialAverage = $collegeFinancialAverage;
		$this->collegeAcceptRate = $collegeAcceptRate;
		$this->collegeProfessorCount = $collegeProfessorCount;
		$this->collegeSize = $collegeSize;
		$this->collegeWomanRatio = $collegeWomanRatio;
		$this->collegeACT = $collegeACT;
		$this->collegeSAT = $collegeSAT;
		$this->collegeSetting = $collegeSetting;
	}


	/**
	 * @return mixed
	 */
	public function getCollegeName(){
		return $this->collegeName;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeType(){
		return $this->collegeType;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeStreetAddress(){
		return $this->collegeStreetAddress;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeCity(){
		return $this->collegeCity;
	}

	/**
	 * @return mixed
	 */
	public function getProvinceID(){
		return $this->provinceID;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeZip(){
		return $this->collegeZip;
	}

	/**
	 * @return mixed
	 */
	public function getCollegePhone(){
		//TODO: get the country code based on provinceID
		return $this->collegePhone;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeInStateTuition(){
		return $this->collegeInStateTuition;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeOutStateTuition(){
		return $this->collegeOutStateTuition;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeFinancialAverage(){
		return $this->collegeFinancialAverage;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeAcceptRate(){
		return $this->collegeAcceptRate;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeProfessorCount(){
		return $this->collegeProfessorCount;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeSize(){
		return $this->collegeSize;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeWomanRatio(){
		return $this->collegeWomanRatio;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeACT(){
		return $this->collegeACT;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeSAT(){
		return $this->collegeSAT;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeSetting(){
		return $this->collegeSetting;
	}
	private $collegeProfessorCount;
	private $collegeSize;
	private $collegeWomanRatio;
	private $collegeACT;
	private $collegeSAT;
	/**
	 * The type of surrounding area that the college is located at
	 * "Urban", "Suburban", "Rural", "Small Town"
	 * @var
	 */
	private $collegeSetting;


}