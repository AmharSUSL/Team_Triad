 <?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "passportinfo";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM passport";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        $expiry_date = strtotime($row["expiry_date"]);
        $current_date = strtotime(date("Y-m-d"));
        $days_left = floor(($expiry_date - $current_date) / (60 * 60 * 24));

        if ($days_left == 60) {
            $to = $row["email"];
            $subject = "Important Reminder: Your Sri Lankan Passport Expires Soon!";
            $message = "
                <p>Dear {$row['holder_name']},<br><br>
                This email is from the Sri Lankan Passport Expiry Alert System to remind you that your passport is due to expire soon.<br><br>
                Your passport will expire on {$row['expiry_date']}.<br><br>
                To ensure a smooth travel experience, we highly recommend renewing your passport well in advance of the expiry date.
                Here are some helpful resources to get you started:<br>
                <ul>
                    <li>
                        Online Passport Renewal Application: <a href=\"//www.immigration.gov.lk/pages_e.php?id=38\" target=\"_blank\">Click Here</a>
                    </li><br>
                    <li>
                        Department of Immigration and Emigration Website: <a href=\"https://www.immigration.gov.lk/\" target=\"_blank\">Click Here</a>
                    </li><br>
                    <li>
                        Contact Information for Passport Renewal Inquiries: <a href=\"tel:0112543981,0113479526\" target=\"_blank\">Click Here</a>
                    </li>
                </ul>
                Please note: These are just some general resources, and the specific requirements for passport renewal may vary depending on your circumstances. We recommend visiting the 
                Department of Immigration and Emigration website or contacting them directly for the latest information and application procedures.<br><br>
                We encourage you to take action as soon as possible to avoid any last-minute delays in renewing your passport.<br><br>
                Thank you for using the Sri Lankan Passport Expiry Alert System!<br><br>
                Sincerely,<br>
                The Sri Lankan Passport Expiry Alert System Team.<br>
                </p>";

            $headers = 'From: Passportrenewal.com <no-reply@passportrenewal.com>' . "\r\n" .
                       'Reply-To: no-reply@passportrenewal.com' . "\r\n" .
                       'Content-type: text/html; charset=UTF-8' . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();

            if (mail($to, $subject, $message, $headers)) {
                echo "Email sent to {$to}<br>";
            } else {
                echo "Failed to send email to {$to}<br>";
            }
        }
    }
} else {
    echo "0 results";
}
$conn->close();
?>
