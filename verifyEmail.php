<html>
<head>
    <title>Bread Bin</title>
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
</head>
<body>
    <div id="mid">
        <div class="verify" style="display:block;">
            <div id="header">
                <h2>Email Validation</h2>
            </div>

            <hr></hr>

            <div style="font-size:0.9em;">
                <?php
                    require("php/common.php");

                    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
                        $query = "SELECT * FROM uniquelogs WHERE hash = :hash";
                        $query_params = array(':hash' => $_GET['hash']); 
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

                                echo "<p>You've successfully validated your email.</p><p>Please click <a class='loginBtn'>here</a> to login.";
                            } else {
                                echo "<p>Your email could not be validated - please tell an administrator.</p>";
                            }
                        } else {
                            echo "<p>The URL is either invalid or you have already activated your account.</p>";   
                        }
                    } else {
                         echo "<p>Invalid URL - please use the link within your email.</p>";
                    }
                ?>
            </div>

            <div class="dockBottom">
                <ul>
                    <li>Terms of Service</li>
                    <li>Privacy Policy</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>