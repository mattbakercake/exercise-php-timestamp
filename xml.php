<?php
/**
 * xml class contains all xml manipulation functions
 *
 * @author Matt
 */
class xml {
    
    /**
     * create a valid XML file from the passed $dataArray with the 
     * name $filename, containing timestamps of the given 
     * $timeszone in the format 
     * <timestamp time="1246406400" text="2009-06-30 13:00:00" GMT/>
     * 
     * @param string $filename
     * @param array $dataArray
     * @param string $timezone
     */
    public function makeXML($filename,$dataArray,$timezone) {
        //set timezone
        switch ($timezone) {
                case 'PST': //PST (GMT-8)
                        date_default_timezone_set('Etc/GMT+8');
                        break;
                default: //default timezone (GMT)
                        date_default_timezone_set('Etc/GMT');
                        break;
        }
        
        //create xml doc
        $doc = new DOMDocument("1.0"); //instantiate PHP DOMDocument object
        $doc->encoding="UTF-8"; //set character encoding
      
        $root = $doc->createElement("timestamps"); //xml root element
        $doc->appendChild($root);
        
        //add child elements
        foreach ($dataArray as $data) {
                $timeStr = date('Y-m-d G:i:s',$data);

                $timestamp = $doc->createElement("timestamp"); 
                $root->appendChild($timestamp);//timestamp element
    
                $timeAttr = $doc->createAttribute("time");
                $timestamp->appendChild($timeAttr); //time attribute
                
                $timeVal = $doc->createTextNode($data);
                $timeAttr->appendChild($timeVal); //time attribute value
                
                $textAttr = $doc->createAttribute("text");
                $timestamp->appendChild($textAttr); //text attribute
                
                $textVal = $doc->createTextNode($timeStr);
                $textAttr->appendChild($textVal); //text attribute value
        }
        $doc->save($filename);
    }
    
    /**
     * parse XML file $filename and extract the timestamp returning 
     * an array containing all timestamps in the file
     * 
     * @param string $filename
     * @return array
     */
    public function parseXML($filename) {
        $doc = new DOMDocument;
        $doc->load($filename); //open xml file
        
        $timestamps = $doc->getElementsByTagName("timestamp"); //grab timestamp
        
        $tsVal = array();
        foreach ($timestamps as $timestamp) { //add timestamp to array
                 array_push($tsVal,$timestamp->attributes->getNamedItem('time')->value);
        }

        return $tsVal;
    }
}

?>
