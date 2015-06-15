<?php
    require("common.php");
    $successful = false;

    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
        $query = "SELECT * FROM uniquelogs WHERE hash = :hash";
        $query_params = array(':hash' => $_POST['hash']); 
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 

        $row = $stmt->fetch(); 

        if ($row) {
            $userid = $row['userid'];
            
            $query = "SELECT * FROM users WHERE id = :id";
            $query_params = array(':id' => $userid); 
            try { 
                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            } 
            catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 

            $row = $stmt->fetch(); 

            if ($row) {
                $query = "UPDATE users SET active=1 WHERE id = :id";
                $query_params = array(':id' => $userid); 
                try { 
                    $stmt = $db->prepare($query); 
                    $result = $stmt->execute($query_params); 
                } 
                catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }  

                $successful = true;
            }
        }
    }
?>

<html>
<head>
    <title>Bread Bin</title>
    <link href="/css/index.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/jquery.cookie.js"></script>
</head>
<body>
    
    <?php if($successful){ ?>
        <div id="mid">
            <div class="verify">
                <div id="header">
                    <h2>Success!</h2>
                </div>

                <hr></hr>

                <div style="font-size:0.9em;">
                    <p>You've successfully validated your email.</p> 
                </div>

                <div class="dockBottom">
                    <ul>
                        <li>Terms of Service</li>
                        <li>Privacy Policy</li>
                    </ul>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div id="mid">
            <div class="verify">
                <div id="header">
                    <h2>Error!</h2>
                </div>

                <hr></hr>

                <div style="font-size:0.9em;">
                    <p>We encountered an error :(</p> 
                </div>

                <div class="dockBottom">
                    <ul>
                        <li>Terms of Service</li>
                        <li>Privacy Policy</li>
                    </ul>
                </div>
            </div>
        </div>
    <?php } ?>
</body>
</html>