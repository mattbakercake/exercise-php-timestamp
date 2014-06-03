<!DOCTYPE html>
<html>
<head><title>Timestamp Puzzle</title>
</head>

<body>
    <?php 
    require 'autoloader.php'; //autoload classes
    
    $firstxml = (file_exists("first.xml"))? true : false;
    $secondxml = (file_exists("second.xml"))? true : false;
    
    //title and buttons
    echo "<h1>XML Timestamp Puzzle</h1>";
    
    echo "<p>Write a PHP program that generates an XML file containing every 30th of June 
    since the Unix Epoch, at 1pm GMT, similar to:<br/><br>
        <pre>
            &lt;?xml version=\"1.0\" encoding=\"UTF-8\"?&gt;
            &lt;timestamps&gt;
            &lt;timestamp time=\"1246406400\" text=\"2009-06-30 13:00:00\" /&gt;
            &lt;/timestamps&gt;
        </pre>

        The program must also parse the generated XML file and generate a second XML file 
        sorted by timestamp in descending order, excluding years that are prime numbers. 
        The timestamps generated should be at 1pm PST.

        We must be able to run these steps separately. <br/><br />

        You need to solve the problem but also show us your knowledge of professional PHP 
        coding and OOP.</p>";
    
    echo '<p><input type="button" onclick="window.location=\'index.php?action=gmt\'" value="Generate 1st XML File"></p>';
    if ($firstxml) { echo '<p><input type="button" onclick="window.location=\'index.php?action=pst\'" value="Generate 2nd XML File"></p>';}
        
    //links to view generated xml
    if($firstxml) { echo "<p><a href='first.xml'>View first.xml</a></p>"; }
    if($secondxml) { echo "<p><a href='second.xml'>View second.xml</a></p>"; }
        
    //process button presses
    if (isset($_GET['action'])) {
        if ($_GET['action'] == "gmt") {
                $tz = new timezone();
                $tz->genGMTxml('first.xml'); //generate the first timestamp file
                echo "<script>location.href='index.php'</script>"; //refresh page to display link
        }
        if ($_GET['action'] == "pst" & file_exists('first.xml')) {
                $tz = new timezone();
                $tz->genPSTxml('first.xml','second.xml'); //generate the second timestamp file
                echo "<script>location.href='index.php'</script>"; //refresh page to display link
        }
    }
    ?>
</body>