<?php 
    require("common.php"); 
    if(empty($_SESSION['user'])) 
    {  
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    }
    if(empty($_SESSION['pid'])){
        header("Location: search.php"); 
        die("Redirecting to search.php");
    } else {
        $pid = $_SESSION['pid'];
    }

    require("src/php_libs/selector_builder.php");
    require("src/php_libs/return_demographic.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>portal - <?php print return_demographic($pid, 0); ?> - Selector</title>
        <link href="src/style/general.css" type="text/css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/png" href="src/favicon.png" />
        <link href="src/style/inverse_bg_circles.css" type="text/css" rel="stylesheet" />
        <link href="src/style/selector.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div id="background">
            <div id="mid_circle"></div>
            <div id="left_top_circle"></div>
            <div id="left_bottom_circle"></div>
            <div id="right_top_circle"></div>
            <div id="right_bottom_circle"></div>
        </div>
       <div id="initialize_selector">
            <table >
                <tr id="initialize_select_first_line">
                    <th colspan="1">Select boxes to show on dashboard</th>
                </tr>
                <tr>
                    <td>
                        <?php selector_builder(); ?>
                    </td>
                </tr>
            </table>
        </div>  
     <div id="selector_footer">
          <div id="selector_footer_demographics">
          		<!-- Name of layout: n/a -->
          		<p>Numbers of boxes selected: <span id="selected_counter">0</span></p>
              </div> 
            <table id="selector_footer_table">
              
                <tr>
                    <td>
                    <form method="link" action="dashboard.php">
                        <button type="button" onclick="window.location = 'dashboard.php'">Discard</button>
                    </form>
                    </td>
                    <td align="right">
                        <button type="button" id="selector_submit">Save</button>
                    </td>
                </tr>
            </table>
        </div>
        </div>
         
    </body>
</html>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
    var selected = new Array();
    var counter = 0;

    Array.prototype.remove = function(value) {
        var index = this.indexOf(value);
        if (index != -1) {
            return this.splice(index, 1);
        }

        return false;
    }

    $('.boxes').click(function() {
        if($(this).hasClass('active')) {
            counter--;
            selected.remove($(this).attr('id'));
            $(this).removeClass('active');
        } else {
            counter++;
            selected.push($(this).attr('id'));
            $(this).addClass('active');
        }
        $('#selected_counter').html(counter);

        selected.sort();
        
    });

    $('#selector_submit').click(function() {
        var boxes = "";
        $.each(selected, function( index, value ) {
          boxes += value + "_";
        });
        window.location = 'update_session.php?boxes=' + boxes;
    })
</script>