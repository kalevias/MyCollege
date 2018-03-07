<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 05/03/18
 * Time: 10:33
 */
//How many results that are returned
$RESULT_COUNT = 5;
/**
 * Returns an inorder list of college IDs
 */
public function scoreCollege($student, $college){
	$studentScore = 0;
	$collegeScore = 0;

	foreach($student->answers as $answer){
		$question = $answer->getQuestion();
		switch($question->getPkID()){
			//What kind of area would you like your college to be located at?
			//enum using [Urban, Suburban, Rural, Small Town]
			case(11):
				if($answer->getAnswer() === $college->getSetting()){
					$studentScore += $answer->getWeight();
					$collegeScore += $answer->getWeight();
				}else{
					//since they dont match find the distance between responses
					$diff = abs($answer->getAnswer() - $college->getSetting());
					// reduce weight proportioanlly by the distance from students's answer
					$collegeScore += floor($answer->getWeight() / ($diff * 2));
				}
				break;
			default:
				break;
		}
	}

}