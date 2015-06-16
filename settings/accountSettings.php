<?php 
    include('../php/init.php');
    require("../php/checkLogin.php");
    require("../php/common.php"); 

    $query = "SELECT * FROM users WHERE id = :id"; 
    $query_params = array(':id' => $_SESSION['user']['id']); 

    try{ 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } 
    catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
    $row = $stmt->fetch();

    if($row){ 
        $userid = $row['id'];
        $email = $row['email'];
        $firstname = $row['firstname'];
        $firstname = $row['lastname'];
    }
?>
<html>
<head>
    <title>Bread Bin</title>
    <link href="../css/main.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script src="../js/jquery-1.11.2.min.js"></script>
    <script src="../js/jquery.cookie.js"></script>
    <script src="../js/checkLogin.js"></script>
</head>
    
<body>
    <?php require('../php/template/settingsNavbar.php');?>
    
    <div id="settingsBox" style="height:500px;">
        <div class="leftSettings">
            <ul class="settingsList">
                <li class="settingsListFirst">
                    Account Details
                </li>
            <a href="privacySettings.php" class="settingsLinks">
                <li class="settingsList">
                    Privacy
                </li>
            </a>
                <li class="settingsList">
                    Privacy
                </li>
                <li class="settingsList">
                    Privacy
                </li>
                <li class="settingsList">
                    Privacy
                </li>
                <li class="settingsList">
                    Privacy
                </li>
                <li class="settingsListLast">
                    Privacy
                </li>
            </ul>
        </div>
        
        <div class="rightSettings">
            <div class="settingsField">
                <div class="settingsHeader">
                    <h3 class="settings">Account Details</h3>
                    <p class="settingsDetail">Update your account details</p>
                </div>
                <form action="../php/SettingsUpdate.php" method="post" class="accountSettings">
                    <label>First name: </label>
                        <input type="text" name="firstname" class="settings" id="setFirstname" value="<?php echo $firstname ?>">
                        <br>
                        <br>
                    <label>Last name: </label>
                        <input type="text" name="lastname" class="settings" id="setLastname" value="<?php echo $lastname ?>">
                        <br>
                        <br>
                    <label>Email: </label>
                        <input type="text" name="email" class="settings" id="setEmail" alue="<?php echo $email ?>">
                        <br>
                        <br>
                   <label> Colour: </label>
                        <select name="colour" class="settings" id="setColour">
                            <option value="1" style="background:#8AE68A">Green</option>
                            <option value="2" style="background:#6699FF">Blue</option>
                            <option value="3" style="background:#FFB540">Orange</option>
                            <option value="4" style="background:#FF66CC">Pink</option>
                        </select>
                        <br>
                        <br>
                    <label> </label>
                        
                        <input type="submit" value="Save" class="saveSettings">
                </form>
            </div>
        </div>
    </div>
<script src="../js/formSettings.js"></script>
</body>
</html>