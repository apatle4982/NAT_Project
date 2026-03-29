<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* 
$ftp_server = "lrsnew.tiuconsulting.us";
$ftp_username = "lrsnewtiuconsult";
$ftp_password = "56&^Q?~1MQl9";

$new_username = "mjtest1";
$new_password = "Tiu_admin123@";
$new_user_directory = "/home/lrsnewtiuconsult/public_html";

// Connect to the FTP server
$ftp_conn = ftp_connect($ftp_server);
if (!$ftp_conn) {
    die("Could not connect to FTP server");
}

// Login to the FTP server
if (!ftp_login($ftp_conn, $ftp_username, $ftp_password)) {
    die("FTP login failed");
}

// Create a new user account
if (ftp_exec($ftp_conn, "MKD $new_user_directory/$new_username")) {
    echo "User directory created successfully\n";
} else {
    echo "User directory creation failed\n";
}

// Set permissions for the new user directory
if (ftp_exec($ftp_conn, "SITE CHMOD 755 $new_user_directory/$new_username")) {
    echo "Permissions set successfully\n";
} else {
    echo "Permission setting failed\n";
}

// Close the FTP connection
ftp_close($ftp_conn); */
 
/* 
// FTP server details
$ftpServer = 'lrsnew.tiuconsulting.us';
$ftpAdminUser = 'lrsnewtiuconsult';
$ftpAdminPass = '56&^Q?~1MQl9';

// New user details
$newUsername = 'mjtest';
$newPassword = 'Tiu_admin123@';
$newUserDir = '/home/lrsnewtiuconsult/public_html/mjtest'; // Replace with the desired directory

// Command to create FTP user
$createCommand = "sudo pure-pw useradd $newUsername -u ftpuser -d $newUserDir -f /etc/pure-ftpd/passwd/pureftpd.passwd";

// Execute the command
$output = exec("echo '$ftpAdminPass' | sudo -S $createCommand");
var_dump($output);
if ($output === null) {
    echo "User creation failed.";
} else {
    echo "User created successfully.";
}
 */

/* 
$ftpServer = 'lrsnew.tiuconsulting.us';
$ftpPort = 21; 
$ftpUsername = 'lrsnewtiuconsult';
$ftpPassword = '56&^Q?~1MQl9';

$newUsername = 'mjtest';
$newPassword = 'Tiu_admin123@';
 
$newUserDirectory = 'testmj';

// Connect to the FTP server
$connection = ftp_connect($ftpServer, $ftpPort);
if (!$connection) {
    die("Could not connect to FTP server");
}

// Login using admin credentials
if (!ftp_login($connection, $ftpUsername, $ftpPassword)) {
    die("Login failed");
}

// Create the new user's directory
if (!ftp_mkdir($connection, $newUserDirectory)) {
    die("Failed to create user directory");
}

// Set permissions for the new user's directory
if (!ftp_chmod($connection, 0777, $newUserDirectory)) {
    die("Failed to set directory permissions");
}

// Create FTP account using SITE command
$command = "SITE ADDUSER $newUsername $newPassword $newUserDirectory";
if (!ftp_site($connection, $command)) {
    die("Failed to create FTP account");
}

// Disconnect from the FTP server
ftp_close($connection);

echo "FTP account created successfully!";
 */

 /* 
$username = "mjtest";
$password = "Tiu_admin123@";
$homeDir = "/home/lrsnewtiuconsult/public_html";

$command = "useradd -d $homeDir -s /sbin/nologin $username";
exec($command." 2>&1", $output);
echo "<pre>";
var_dump($output);
echo "</pre>";
 

$command = "echo '$username:$password' | chpasswd";
exec($command);
 */
// Set appropriate permissions and configurations on the $homeDir if needed
 

/* 
$ftpServer = 'lrsnew.tiuconsulting.us';
$ftpUsername = 'lrsnewtiuconsult';
$ftpPassword = '56&^Q?~1MQl9';

$newFtpUsername = 'mjtest';
$newFtpPassword = 'Tiu_admin123@';

// Connect to the FTP server
$ftpConnection = ftp_connect($ftpServer);
if (!$ftpConnection) {
    die("Could not connect to FTP server");
}

// Login to the FTP server
if (!ftp_login($ftpConnection, $ftpUsername, $ftpPassword)) {
    die("Could not login to FTP server");
}

// Create a new FTP user
if (ftp_adduser($ftpConnection, $newFtpUsername, $newFtpPassword, '/home/lrsnewtiuconsult/public_html')) {
    echo "FTP account created successfully";
} else {
    echo "Failed to create FTP account";
}

// Close the FTP connection
ftp_close($ftpConnection); */
 /* 
// FTP server details
$ftp_server = 'lrsnew.tiuconsulting.us';
$ftp_username = 'lrsnewtiuconsult';
$ftp_password = '56&^Q?~1MQl9';

// New FTP user details
$new_username = 'mjtest';
$new_password = 'Tiu_admin123@';

// Connect to the FTP server
$ftp_conn = ftp_connect($ftp_server);

if ($ftp_conn) {
    // Login to the FTP server
    $login_result = ftp_login($ftp_conn, $ftp_username, $ftp_password);

    if ($login_result) {
        // Create a new FTP user directory
        if (ftp_mkdir($ftp_conn, $new_username)) {
            echo "FTP user directory created successfully.\n";

            // Set the permissions for the new directory
            ftp_chmod($ftp_conn, 0755, $new_username);

            // Create the new user's FTP account
            if (ftp_exec($ftp_conn, "SITE ADDUSER $new_username $new_password $new_username")) {
                echo "FTP user account created successfully.\n";
            } else {
                echo "Failed to create FTP user account.\n";
            }
        } else {
            echo "Failed to create FTP user directory.\n";
        }

        // Close the FTP connection
        ftp_close($ftp_conn);
    } else {
        echo "FTP login failed.\n";
    }
} else {
    echo "Failed to connect to FTP server.\n";
} */
?> 

