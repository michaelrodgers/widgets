
<?php
    
/*
if day is passed via GET, show $day's coffee
if it's today, shows $today's coffee
place a link to show today's coffee (if on another day)
*/
    
if(isset($_GET['day']))
{//if day is passed via GET, show $day's coffee
    $today = $_GET['day'];
}else{//if it's today, shows $today's coffee
   $today = date('l'); 
}
    
switch($today){
        
    case 'Monday':
        $coffee = "Canadian Americano";
        $description = 'Triple expresso on 60mL of water';
        $backcolor = 'red';
        $textcolor = 'white';
        $pic = 'monday.jpg';
        $alt = 'Canadian Americano';
    break;
        
    case 'Tuesday':
        $coffee = "Doubles + Bubbles";
        $description = 'Double shot of expresso with a soda back and a candied orange';
        $backcolor = 'orange';
        $textcolor = 'black';
        $pic = 'tuesday.jpg';
        $alt = 'Doubles and Bubbles';
    break;
        
    case 'Wednesday':
        $coffee = "Lazy Latte";
        $description = 'French pressed coffee with steamed almond milk and microfoam';
        $backcolor = 'white';
        $textcolor = 'brown';
        $pic = 'wednesday.jpg';
        $alt = 'Lazy Latte';
    break;
        
    case 'Thursday':
        $coffee = "Hot Mess Macchiato";
        $description = 'Double expresso with a dollop of steamed milk and foam';
        $backcolor = 'brown';
        $textcolor = 'silver';
        $pic = 'thursday.jpg';
        $alt = 'Hot Mess Macchiato';
    break;

    case 'Friday':
        $coffee = "Buttered Up Cappuccino";
        $description = 'Double expresso with steamed buttermilk and free poured microfoam, flavored with maple honey';
        $backcolor = 'honeydew';
        $textcolor = 'darkmagenta';
        $pic = 'friday.jpg';
        $alt = 'Buttered Up Cappuccino';
    break;
        
    case 'Saturday':
        $coffee = "Nutty Mocha";
        $description = 'Nutella-flavored chocolate, double expresso, steamed almond milk and microfoam';
        $backcolor = 'green';
        $textcolor = 'darksalmon';
        $pic = 'saturday.jpg';
        $alt = 'Nutty Mocha';
    break;
        
    case 'Sunday':
        $coffee = "Straight Up Expresso";
        $description = 'Double shot of expresso';
        $backcolor = 'goldenrod';
        $textcolor = 'ghostwhite';
        $pic = 'sunday.jpg';
        $alt = 'Straight Up Expresso';
    break;
}
?>           

<?php include 'includes/config.php'?>
<?php get_header()?>

<div style="margin-left: auto; margin-right: auto; height: 800px; background-image: url('https://michaelrodgers.azurewebsites.net/itc240/sandbox/coffeeimages/<?php echo $pic ?>'); background-repeat: no-repeat; background-position: center;" alt='<?php echo $alt ?>'>
            <h3 style="margin-left: auto; margin-right: auto; background-color:<?php echo $backcolor ?>; color:<?php echo $textcolor ?>; position: relative; top: 40%; width: 12em; font-size: 3em;"><?php echo $coffee ?></h3>
            <p style="margin-left: auto; margin-right: auto; background-color:<?php echo $backcolor ?>; color:<?php echo $textcolor ?>; position: relative; top: 50%; width: 16em;"><?php echo $description ?></p>
        </div>
        <p style="font-size: 1.2em;">Enjoy a <?php echo $coffee ?> at Cafe Logos for just $3 every <?php echo $day ?>, open 8am-8pm.</p>

<p>Click below to find out our other specials: </p>
<p><a href="daily.php?day=Sunday">Sunday</a></p>
<p><a href="daily.php?day=Monday">Monday</a></p>
<p><a href="daily.php?day=Tuesday">Tuesday</a></p>
<p><a href="daily.php?day=Wednesday">Wednesday</a></p>
<p><a href="daily.php?day=Thursday">Thursday</a></p>
<p><a href="daily.php?day=Friday">Friday</a></p>
<p><a href="daily.php?day=Saturday">Saturday</a></p>


<?php get_footer()?>