<?php
/**
 * The timezone class contains timezone methods
 *
 * @author Matt
 */
class timezone {

	private $currentTimestamp; //secs since epoch 
	private $epochTarget; // 13:00 30th June 1970
	
        /**
         * Creates a timestamp of current local time and a target timestamp of
         * 30th June 1970 at 13:00 GMT
         */
	function __construct() {
            $this->setCurrentTimestamp(); 
            $this->setEpochTarget(); 
	}
	
	/*
        * sets current timestamp
        */
	private function setCurrentTimestamp() {
            $this->currentTimestamp = time();
	}
	
        /*
        * sets class variable to target timestamp
        */
	private function setEpochTarget() {
            $target = strtotime('1970:06:30 13:00:00 GMT',$this->currentTimestamp);
            $this->epochTarget = $target;
	}
	
        /*
        * returns current unix timestamp
        */
	public function getCurrentTimestamp() {
            return $this->currentTimestamp;
	}
	
        /*
        *  returns a unix timestamp of the target time(13:00 30th June 1970)
        */
	public function getEpochTarget() {
            return $this->epochTarget;
	}
	
        /*
        * returns an array containing unix timestamps from 
        * target time + 1 year up to current time
        * 
        * @return array
        */
	public function getTimestamps() {
            $timeStamps = array();
            $thisTime = $this->epochTarget;
            while ($thisTime < $this->currentTimestamp) {
                    array_push($timeStamps,$thisTime);
                    $thisTime = strtotime('+ 1 year',$thisTime);
            }
            
            return $timeStamps;
	}
	
        /*
        * parses XML file and returns array containing
        * original timestamps adjusted from 13:00 to 21:00 GMT 
        * to display 13:00 PST(GMT-8)
        * 
        * @return array
        */
	private function getPSTTimestamps($filename) {
            $xml = new xml(); //instantiate custom xml() class
            $timestamps = $xml->parseXML($filename);
            $pstTimeStamps = array();
            foreach ($timestamps as $value) {
                    array_push($pstTimeStamps, strtotime('+8 hours',$value));
            }
            return $pstTimeStamps;
	}
	
        /**
         * calculate if number is prime by dividing it by all factors
         * from 2 to the number's value and return a boolean indicating
         * its status
         * 
         * @param int $number
         * @return boolean
         */
	private function isPrime($number) {
            $prime = true;
            for($x=2;$x<$number;$x++) {
                    $result = ($number/$x);
                    if (is_int($result)) {
                            $prime = false;
                    }
            }

            return $prime;
	}
	
        /**
         * generates a valid XML file containing every 30th June 1970 13.00
         * ascending from unix epoch to current date, with the filename passed 
         * to the function
         * 
         * @param string $filename
         */
	public function genGMTxml($filename) {
            $timestamps = $this->getTimestamps();
            $xml = new xml(); //instantiate custom xml() class
            $xml->makeXML($filename,$timestamps,'GMT');
	}
	
        /**
         * takes the XML file $inputfile, parses it and outputs
         * a second XML file with name passed by $outputfile.  This
         * file contains the input timestamps reverse sorted at 1pm PST
         * excluding the years that are prime numbers
         * 
         * @param string $inputfile
         * @param string $outputfile
         */
	public function genPSTxml($inputfile,$outputfile) {
            $timestamps = $this->getPSTTimestamps($inputfile);
            rsort($timestamps);
            $xml = new xml(); //instantiate custom xml() class
            $noPrimeDates = array();
            foreach ($timestamps as $timestamp) {
                    $year = date('Y',$timestamp);
                    if (!$this->isPrime($year)) {
                            array_push($noPrimeDates,$timestamp);
                    }
            }
            $xml->makeXML($outputfile,$noPrimeDates,'PST');
	}
}

?>
