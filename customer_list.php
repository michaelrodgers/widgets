<?php
//customer_list.php - shows a list of customer data
?>
<?php include 'includes/config.php'?>
<?php get_header()?>
<?php
$sql = "select * from banned_books";
//we connect to the db here
$iConn = @mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die(myerror(__FILE__,__LINE__,mysqli_connect_error()));

//we extract the data here
$result = mysqli_query($iConn,$sql) or die(myerror(__FILE__,__LINE__,mysqli_error($iConn)));

if(mysqli_num_rows($result) > 0)
{//show records

    while($row = mysqli_fetch_assoc($result))
    {
        echo "<p>";
	   echo "Title: <b>" . $row['Title'] . "</b><br />";
       echo "Author: <b>" . $row['Author'] . "</b><br />";
	   echo "Year Published: <b>" . $row['YearPublished'] . "</b><br />";
        
        echo '<a href="customer_view.php?id=' . $row['BookID'] . '">' . $row['Title'] . '</a>';
        
        echo '</p>';
    }    

}else{//inform there are no records
    echo '<p>There are currently no books</p>';
}

//release web server resources
@mysqli_free_result($result);

//close connection to mysql
@mysqli_close($iConn);

?>
<?php get_footer()?>