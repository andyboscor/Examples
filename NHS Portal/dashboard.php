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

    require("src/php_libs/dashboard_builder.php");
    require("src/php_libs/return_demographic.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>portal - <?php print return_demographic($pid, 0); ?> - Dashboard</title>
        <link href="src/style/general.css" type="text/css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/png" href="src/favicon.png" />
        <link href="src/style/background_circles.css" type="text/css" rel="stylesheet" />
        <link href="src/style/dashboard.css" type="text/css" rel="stylesheet" />
        <link href="src/style/dashboard_structures.css" type="text/css" rel="stylesheet" />
        <script src="src/script/dashboard.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="background">
            <div id="mid_circle"></div>
            <div id="left_top_circle"></div>
            <div id="left_bottom_circle"></div>
            <div id="right_top_circle"></div>
            <div id="right_bottom_circle"></div>
        </div>
        <div id="dashboard_container">
            <table id="dashboard_container_table">
                <tr>
                    <?php table_builder(); ?>
                    <!-- <td>
                        <div class="dashboard_box" id="dashboard_box1">
                            <div class="dashboard_box_title">Long text demo</div>
                            <div class="dashboard_box_content">
                                <div class="dashboard_box_entry_title" class="dashboard_box_entry_long_text_title">Just a long text passing by</div>
                                <div class="dashboard_box_structure_long_text" id="dashboard_box1_entry1" onmouseover="expandTextBox(this)" onmouseout="collapseTextBox(this)">Text.....</div>
                                <div class="dashboard_box_entry_title">Random text to show drifting</div>
                            </div>
                        </div>
                        <div class="dashboard_box" id="dashboard_box2">
                            <div class="dashboard_box_title">Small text fields</div>
                            <div class="dashboard_box_content">
                                <p><span class="dashboard_box_entry_small_title">Title of entry:</span><span class="dashboard_box_entry_small_data">Text field data</span></p>
                                <p><span class="dashboard_box_entry_small_title">Small text entry:</span><span class="dashboard_box_entry_small_data">Some data</span></p>
                                <p><span class="dashboard_box_entry_small_title">Showing off my HTML skills:</span><span class="dashboard_box_entry_small_data">E=mc<sup>2</sup></span></p>
                                <p><span class="dashboard_box_entry_small_title">If things get out of control:</span><span class="dashboard_box_entry_small_data">And the entry size becomes too too too too long......</span></p>
                                <p><span class="dashboard_box_entry_smallnum_title">Numeric small entry:</span><span class="dashboard_box_entry_smallnum_data">123456789</span><span class="dashboard_box_entry_smallnum_unit">pieces</span></p>
                                <p><span class="dashboard_box_entry_smallnum_title">I can run:</span><span class="dashboard_box_entry_smallnum_data">20</span><span class="dashboard_box_entry_smallnum_unit">km/h</span></p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="dashboard_box" id="dashboard_box3">
                            <div class="dashboard_box_title">Pregnancy</div>
                        </div>
                        <div class="dashboard_box" id="dashboard_box4">
                            <div class="dashboard_box_title">Eye-candy table</div>
                            <div class="dashboard_box_content">
                                <table id="dashboard_box4_entry1" class="structure_table">
                                    <tr>
                                        <td id="dashboard_box4_entry1_table_11" class="dashboard_entry_table_empty" style="">&nbsp;</td>
                                        <td id="dashboard_box4_entry1_table_12" class="dashboard_entry_table_row1">Date 1</td>
                                        <td id="dashboard_box4_entry1_table_13" class="dashboard_entry_table_row1">Date 2</td>
                                        <td id="dashboard_box4_entry1_table_14" class="dashboard_entry_table_row1">Date 3</td>
                                        <td id="dashboard_box4_entry1_table_15" class="dashboard_entry_table_row1">Date 4</td>
                                    </tr>
                                    <tr>
                                        <td id="dashboard_box4_entry1_table_21" class="dashboard_entry_table_col1">Data1</td>
                                        <td id="dashboard_box4_entry1_table_22" onmouseover="glowTable(this)" onmouseout="clearTable(this)">234</td>
                                        <td id="dashboard_box4_entry1_table_23" onmouseover="glowTable(this)" onmouseout="clearTable(this)">asd</td>
                                        <td id="dashboard_box4_entry1_table_24" onmouseover="glowTable(this)" onmouseout="clearTable(this)">123</td>
                                        <td id="dashboard_box4_entry1_table_25" onmouseover="glowTable(this)" onmouseout="clearTable(this)">qwert</td>
                                    </tr>
                                    <tr>
                                        <td id="dashboard_box4_entry1_table_31" class="dashboard_entry_table_col1">Data2</td>
                                        <td id="dashboard_box4_entry1_table_32" onmouseover="glowTable(this)" onmouseout="clearTable(this)">random</td>
                                        <td id="dashboard_box4_entry1_table_33" onmouseover="glowTable(this)" onmouseout="clearTable(this)">words</td>
                                        <td id="dashboard_box4_entry1_table_34" onmouseover="glowTable(this)" onmouseout="clearTable(this)">stuff</td>
                                        <td id="dashboard_box4_entry1_table_35" onmouseover="glowTable(this)" onmouseout="clearTable(this)">456</td>
                                    </tr>
                                    <tr>
                                        <td id="dashboard_box4_entry1_table_41" class="dashboard_entry_table_col1">Data3</td>
                                        <td id="dashboard_box4_entry1_table_42" onmouseover="glowTable(this)" onmouseout="clearTable(this)">numbers too</td>
                                        <td id="dashboard_box4_entry1_table_43" onmouseover="glowTable(this)" onmouseout="clearTable(this)">456</td>
                                        <td id="dashboard_box4_entry1_table_44" onmouseover="glowTable(this)" onmouseout="clearTable(this)">data</td>
                                        <td id="dashboard_box4_entry1_table_45" onmouseover="glowTable(this)" onmouseout="clearTable(this)">456</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>-->
                </tr>
            </table>
        </div>
        <div id="dashboard_footer">
            <table id="dashboard_footer_table">
                <tr>
                    <td>
                        <div id="dashboard_footer_demographics">
                            Name: <span class="dashboard_info"><?php print return_demographic($pid, 0); ?></span><br />
                            Patient ID: <span class="dashboard_info"><?php print return_demographic($pid, 1); ?></span><br />
                            GP address: <span class="dashboard_info"><?php print return_demographic($pid, 3); ?></span><br />
                            Date of birth: <span class="dashboard_info"><?php print return_demographic($pid, 2); ?></span>
                        </div>
                    </td>
                    
                    <td>
                        <form method="link" action="report.php">
                            <button type="submit">Create letter</button><br />
                        </form>
                        <form method="link" action="search.php">
                            <button type="submit">Change patient</button><br />
                        </form>
                    </td>
                    <td>
                        <form method="link" action="filename.php">
                            <button type="submit">Save layout</button><br />
                        </form>
                        <form method="link" action="selector.php"> 
                            <button type="submit">Edit layout</button>
                        </form>
                    </td>
                    <td>
                        <form method="link" action="logout.php">
                            <button type="submit">Log out</button>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
        </div>
    </body>
    <script>
        sizeBox(<?php return_boxids(); ?>);
    </script>
</html>