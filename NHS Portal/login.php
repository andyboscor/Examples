<?php 
    // from http://forums.devshed.com/php-faqs-stickies-167/program-basic-secure-login-system-using-php-mysql-891201.html
    //require common file to connect to database and start session
    require("common.php"); 
    $submitted_username = 'Username'; 
    $failed_login = '';
    //gets username from database using provided username 
    if(!empty($_POST)) 
    { 
        $query = " 
            SELECT 
                id, 
                username, 
                password
            FROM users 
            WHERE 
                username = :username 
        "; 
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
        //tries to run query
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
        //presume that login is false
        $login_ok = false; 
        $row = $stmt->fetch(); 
        //if inputted password matches database password grant access 
        if($row) 
        { 
             
            if($_POST['password'] == $row['password']) 
            { 
                $login_ok = true; 
            } 
        } 
        //redirect user to page
        //put username in active session username
        // if login failed, the submitted username is remembered in case the user mistyped their password
        if($login_ok) 
        { 
           unset($row['password']); 
            $_SESSION['user'] = $row; 
            header("Location: search.php"); 
            die("Redirecting to: search.php"); 
        } 
        else 
        { 
            $login_failed = 'Login Failed';
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
        } 
    }
?> 
<!DOCTYPE html>
<html>
    <head>
    <!-- Importing all the CSS -->
        <title>Portal - Log in</title>
        <link href="src/style/general.css" type="text/css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/png" href="src/favicon.png" />
        <link href="src/style/background_circles.css" type="text/css" rel="stylesheet" />
        <link href="src/style/login.css" type="text/css" rel="stylesheet" />
        <script src="src/script/login.js" type="text/javascript"></script>
    </head>
    <body>
     <!-- Create background -->
        <div id="background">
            <div id="mid_circle"></div>
            <div id="left_top_circle"></div>
            <div id="left_bottom_circle"></div>
            <div id="right_top_circle"></div>
            <div id="right_bottom_circle"></div>
        </div>
        <!-- Login form that uses js function to keep username in box after failed login-->
        <div id="login">
            <form name="login" action="login.php" method="post">
                <div id="login_id"><input type="text" name="username" value="<?php echo $submitted_username; ?>" id="login_id_input" onfocus="clearInput(this, '<?php echo $submitted_username; ?>')" onblur="checkInput(this, '<?php echo $submitted_username; ?>')"/></div>
                <div id="login_password"><input type="password" name="password" value="password" id='login_password_input' onfocus="clearInput(this, 'password')" onblur="checkInput(this, 'password')"/></div>
                <button type="submit" value="Login">Log in</button>
                
            </form> 
            <!-- Shows login failed when needed -->
             <p><?php if(isset($login_failed)){ echo $login_failed; } ?></p>
        </div>
    </body>
</html>