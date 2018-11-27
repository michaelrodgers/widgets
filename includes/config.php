<?php
/*
config.php

stores configuration information for our web application

*/

//removes header already sent errors
ob_start();

define('SECURE',false); #force secure, https, for all site pages

define('PREFIX', 'widgets_fl18_'); #Adds uniqueness to your DB table names.  Limits hackability, naming collisions

header("Cache-Control: no-cache");header("Expires: -1");#Helps stop browser & proxy caching

define('DEBUG',true); #we want to see all errors

include 'credentials.php';//stores database info
include 'common.php';//stores favorite functions

//prevents date errors
date_default_timezone_set('America/Los_Angeles');

//create config object
$config = new stdClass;

//CHANGE TO MATCH YOUR PAGES
$config->nav1['template-example.php'] = 'Home'; 
$config->nav1['db-test.php'] = 'DB Test'; 
$config->nav1['customer_list.php'] = 'Banned Book List'; 
$config->nav1['daily.php'] = 'Daily'; 
$config->nav1['contact.php'] = 'Contact'; 
/*
 Below is an array of images to be used in the function named 
 randomize()
*/
$config->heros[] = '<img src="images/coulson.png" />';
$config->heros[] = '<img src="images/fury.png" />';
$config->heros[] = '<img src="images/hulk.png" />';
$config->heros[] = '<img src="images/thor.png" />';
$config->heros[] = '<img src="images/black-widow.png" />';
$config->heros[] = '<img src="images/captain-america.png" />';
$config->heros[] = '<img src="images/machine.png" />';
$config->heros[] = '<img src="images/iron-man.png" />';
$config->heros[] = '<img src="images/loki.png" />';
$config->heros[] = '<img src="images/giant.png" />';
$config->heros[] = '<img src="images/hawkeye.png" />';
/*
 Below is an array of images to be used in the function named 
 rotate()
*/
$config->planets[] = '<img src="images/mercury.gif" />';
$config->planets[] = '<img src="images/venus.gif" />';
$config->planets[] = '<img src="images/mars.gif" />';
$config->planets[] = '<img src="images/jupiter.gif />';
$config->planets[] = '<img src="images/saturn.gif" />';
$config->planets[] = '<img src="images/uranus.gif" />';
$config->planets[] = '<img src="images/neptune.gif" />';
$config->planets[] = '<img src="images/pluto.gif" />';

//create default page identifier
define('THIS_PAGE',basename($_SERVER['PHP_SELF']));

//START NEW THEME STUFF - be sure to add trailing slash!
$sub_folder = 'widgets/';//change to 'widgets' or 'sprockets' etc.
$config->theme = 'Brick';//sub folder to themes

//will add sub-folder if not loaded to root:
$config->physical_path = $_SERVER["DOCUMENT_ROOT"] . '/' . $sub_folder;
//force secure website
if (SECURE && $_SERVER['SERVER_PORT'] != 443) {#force HTTPS
	header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}else{
    //adjust protocol
    $protocol = (SECURE==true ? 'https://' : 'http://'); // returns true
    
}
$config->virtual_path = $protocol . $_SERVER["HTTP_HOST"] . '/' . $sub_folder;

define('ADMIN_PATH', $config->virtual_path . 'admin/'); # Could change to sub folder
define('INCLUDE_PATH', $config->physical_path . 'includes/');


//CHANGE ITEMS BELOW TO MATCH YOUR SHORT TAGS
$config->title = THIS_PAGE;
$config->banner = 'Widgets';
$config->loadhead = '';//place items in <head> element

//default page values
$config->title = THIS_PAGE;
$config->siteName = 'Site Name';
$config->slogan = 'Whatever it is you do, we do it better.';
$config->pageHeader = 'The developer forgot to put a pageHeader!';
$config->subHeader = 'The developer forgot to put a subHeader!';
$config->sloganIcon = '';//will be replaced in by hero or planet icons

switch(THIS_PAGE){      
    
    case 'appointment.php':    
        $config->title = 'Appointment Page';
        $config->banner = 'Widget Appointments!';
    break;
        
   case 'template.php':    
        $config->title = 'Template Page';    
        $config->pageHeader = 'Put PageID here';
        $config->subHeader = 'Put more info about page here';
	break;
        
    case 'db-test.php':
		$config->title =  'My Database Test page';
        $config->pageHeader = 'Database Test';
        $config->subHeader = 'Check this page to see if database credentials are correct';
	break;
        
    case 'customer_list.php':
		$config->title =  'Banned Books page';
        $config->pageHeader = 'Banned Books List';
        $config->subHeader = 'Check out this list of banned books';
	break;
        
    case 'about.php':
		$config->title =  'My About page';
        $config->pageHeader = 'About Me';
        $config->subHeader = 'This is what I do';
	break;
        
    case 'daily.php':
		$config->title =  'My Daily page';
        $config->pageHeader = 'Daily Coffee Specials';
        $config->subHeader = 'The special is...';
        $config->sloganIcon = rotate($planets);
	break;    
	
	case 'contact.php':
		$config->title =  'My contact page';
        $config->pageHeader = 'Please contact us';
        $config->subHeader = 'We appreciate your feedback';
        $config->sloganIcon = randomize($heros);
	break;
	
}

//creates theme virtual path for theme assets, JS, CSS, images
$config->theme_virtual = $config->virtual_path . 'themes/' . $config->theme . '/';

/*
 * adminWidget allows clients to get to admin page from anywhere
 * code will show/hide based on logged in status
*/
/*
 * adminWidget allows clients to get to admin page from anywhere
 * code will show/hide based on logged in status
*/
if(startSession() && isset($_SESSION['AdminID']))
{#add admin logged in info to sidebar or nav
    
    $config->adminWidget = '
        <a href="' . ADMIN_PATH . 'admin_dashboard.php">ADMIN</a> 
        <a href="' . ADMIN_PATH . 'admin_logout.php">LOGOUT</a>
    ';
}else{//show login (YOU MAY WANT TO SET TO EMPTY STRING FOR SECURITY)
    
    $config->adminWidget = '
        <a  href="' . ADMIN_PATH . 'admin_login.php">LOGIN</a>
    ';
}
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
?>