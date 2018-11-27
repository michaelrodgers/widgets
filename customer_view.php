<?php
//customer_view.php - shows details of a single customer
?>
<?php include 'includes/config.php'?>
    <?php get_header()?>

<?php

//process querystring here
if(isset($_GET['id']))
{//process data
    //cast the data to an integer, for security purposes
    $id = (int)$_GET['id'];
}else{//redirect to safe page
    header('Location:customer_list.php');
}


$sql = "select * from banned_books where BookID = $id";
//we connect to the db here
$iConn = @mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die(myerror(__FILE__,__LINE__,mysqli_connect_error()));

//we extract the data here
$result = mysqli_query($iConn,$sql) or die(myerror(__FILE__,__LINE__,mysqli_error($iConn)));

if(mysqli_num_rows($result) > 0)
{//show records

    while($row = mysqli_fetch_assoc($result))
    {
        $Title = stripslashes($row['Title']);
        $Author = stripslashes($row['Author']);
        $YearPublished = stripslashes($row['YearPublished']);
        $Description = stripslashes($row['Description']);
        $Feedback = '';//no feedback necessary
    }    

}else{//inform there are no records
    $Feedback = '<p>This book is not on our list</p>';
}

?>

<?php
    
    
if($Feedback == '')
{//data exists, show it

    echo '<p>';
    echo 'Title: <b>' . $Title . '</b> ';
    echo 'Author: <b>' . $Author . '</b> ';
    echo 'Year Published: <b>' . $YearPublished . '</b> ';
    
    echo '<img src="uploads/book' . $id . '.jpg" />';
    echo "Description: <b><br />" . $Description . "</b><br />";
    
    echo '</p>'; 
}else{//warn user no data
    echo $Feedback;
}    

echo '<p><a href="customer_list.php">Go Back</a></p>';

//release web server resources
@mysqli_free_result($result);

//close connection to mysql
@mysqli_close($iConn);

?>
<?php get_footer()?>