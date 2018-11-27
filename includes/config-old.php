<?php
/*
	config.php
	
	Stores configuration data for our application
*/

ob_start();//prevents header errprs
include 'credentials.php';//database credentials
define('DEBUG',TRUE); #we want to see all errors

//echo basename($_SERVER['PHP_SELF']);
define('THIS_PAGE',basename($_SERVER['PHP_SELF']));
//echo 'the constant is storing: ' . THIS_PAGE;
//die;

$nav1['template.php'] = 'Home'; 
$nav1['db-test.php'] = 'DB Test'; 
$nav1['customer_list.php'] = 'Banned Book List'; 
$nav1['daily.php'] = 'Daily'; 
$nav1['contact.php'] = 'Contact'; 

/*
 Below is an array of images to be used in the function named 
 randomize()
*/
$heros[] = '<img src="images/coulson.png" />';
$heros[] = '<img src="images/fury.png" />';
$heros[] = '<img src="images/hulk.png" />';
$heros[] = '<img src="images/thor.png" />';
$heros[] = '<img src="images/black-widow.png" />';
$heros[] = '<img src="images/captain-america.png" />';
$heros[] = '<img src="images/machine.png" />';
$heros[] = '<img src="images/iron-man.png" />';
$heros[] = '<img src="images/loki.png" />';
$heros[] = '<img src="images/giant.png" />';
$heros[] = '<img src="images/hawkeye.png" />';
/*
 Below is an array of images to be used in the function named 
 rotate()
*/
$planets[] = '<img src="images/mercury.gif" />';
$planets[] = '<img src="images/venus.gif" />';
$planets[] = '<img src="images/mars.gif" />';
$planets[] = '<img src="images/jupiter.gif />';
$planets[] = '<img src="images/saturn.gif" />';
$planets[] = '<img src="images/uranus.gif" />';
$planets[] = '<img src="images/neptune.gif" />';
$planets[] = '<img src="images/pluto.gif" />';
//default page values
$title = THIS_PAGE;
$siteName = 'Site Name';
$slogan = 'Whatever it is you do, we do it better.';
$pageHeader = 'The developer forgot to put a pageHeader!';
$subHeader = 'The developer forgot to put a subHeader!';
$sloganIcon = '';//will be replaced in by hero or planet icons


switch(THIS_PAGE){
	
	case 'template.php':
		$title =  'My Template page';
        $pageHeader = 'Put PageID here';
        $subHeader = 'Put more info about page here';
	break;
        
    case 'db-test.php':
		$title =  'My Database Test page';
        $pageHeader = 'Database Test';
        $subHeader = 'Check this page to see if database credentials are correct';
	break;
        
    case 'customer_list.php':
		$title =  'Banned Books page';
        $pageHeader = 'Banned Books List';
        $subHeader = 'Check out this list of banned books';
	break;
        
    case 'customer_view.php':
        if(isset($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        $sql = "select * from banned_books where BookID = $id";
        $iConn = @mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die(myerror(__FILE__,__LINE__,mysqli_connect_error()));
        $result = mysqli_query($iConn,$sql) or die(myerror(__FILE__,__LINE__,mysqli_error($iConn)));
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $Title = stripslashes($row['Title']);
                $Author = stripslashes($row['Author']);
                $YearPublished = stripslashes($row['YearPublished']);
                $title = $Title;
                $pageID = $Title;
                $Feedback = '';//no feedback necessary
            }    
        }else{
            $Feedback = $YearPublished;
        }
        $pageHeader = $Title;
        $subHeader = $Author;
	break;
        
    case 'about.php':
		$title =  'My About page';
        $pageHeader = 'About Me';
        $subHeader = 'This is what I do';
	break;
        
    case 'daily.php':
		$title =  'My Daily page';
        $pageHeader = 'Daily Coffee Specials';
        $subHeader = 'The special is...';
        $sloganIcon = rotate($planets);
	break;    
	
	case 'contact.php':
		$title =  'My contact page';
        $pageHeader = 'Please contact us';
        $subHeader = 'We appreciate your feedback';
        $sloganIcon = randomize($heros);
	break;
	
}
/**
 * returns a random item from an array sent to it.
 *
 * Uses count of array to determine highest legal random number.
 *
 * Used to show random HTML segments in sidebar, etc.
 *
 * <code>
 * $arr[] = '<img src="mypic1.jpg" />';
 * $arr[] = '<img src="mypic2.jpg" />';
 * $arr[] = '<img src="mypic3.jpg" />';  
 * echo randomize($arr); #will show one of three random images
 * </code>
 *
 * @param array array of HTML strings to display randomly
 * @return string HTML at random index of array
 * @see rotate() 
 * @todo none
 */

function randomize ($arr)
{//randomize function is called in the right sidebar - an example of random (on page reload)
	if(is_array($arr))
	{//Generate random item from array and return it
		return $arr[mt_rand(0, count($arr) - 1)];
	}else{
		return $arr;
	}
}#end randomize()

/**
 * returns a daily item from an array sent to it.
 *
 * Uses count of array to determine highest legal rotated item.
 *
 * Uses day of month and modulus to rotate through daily items in sidebar, etc.
 *
 * <code>
 * $arr[] = '<img src="mypic1.jpg" />';
 * $arr[] = '<img src="mypic2.jpg" />';
 * $arr[] = '<img src="mypic3.jpg" />';  
 * echo rotate($arr); #will return a different image each day for three days
 * </code>
 * 
 * @param array array of HTML strings to display on a daily rotation
 * @return string HTML at specific index of array based on day of month
 * @see rotate() 
 * @todo none
 */

function rotate ($arr)
{//rotate function is called in the right sidebar - an example of rotation (on day of month)
	if(is_array($arr))
	{//Generate item in array using date and modulus of count of the array
		return $arr[((int)date("j")) % count($arr)];
	}else{
		return $arr;
	}
}#end rotate

/*
makeLinks() creates navigation items from an array
*/

function makeLinks($nav)
    {
    $myReturn = '';
    foreach($nav as $key => $value){
        if(THIS_PAGE == $key){// current page add active class
        $myReturn.='
        <li class="nav-item">
              <a class="nav-link active" href="'.$key.'">'.$value.'</a>
        </li>';   
        }else{//add no formatting
        $myReturn.='
        <li class="nav-item">
              <a class="nav-link" href="'.$key.'">'.$value.'</a>
        </li>';
        }
    }
    
    return $myReturn;
    }//end makeLinks

function myerror($myFile, $myLine, $errorMsg)
{
    if(defined('DEBUG') && DEBUG)
    {
       echo "Error in file: <b>" . $myFile . "</b> on line: <b>" . $myLine . "</b><br />";
       echo "Error Message: <b>" . $errorMsg . "</b><br />";
       die();
    }else{
		echo "I'm sorry, we have encountered an error.  Would you like to buy some socks?";
		die();
    }
}
