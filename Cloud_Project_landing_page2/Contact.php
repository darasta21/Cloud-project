<?php
                require 'PHPMailer/PHPMailer.php';
                require 'PHPMailer/SMTP.php';
                require 'PHPMailer/Exception.php';
        
                 use PHPMailer\PHPMailer\PHPMailer;
                 use PHPMailer\PHPMailer\SMTP;
                 use PHPMailer\PHPMailer\Exception;
        
                $mail = new PHPMailer(true);
                
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ndivajordan@gmail.com';
                $mail->Password = 'uqwzdxtzbczmrejp';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
        
                
                // Database connection details
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "database contact";
        
                // Create a new database connection
                $conn = new mysqli($servername, $username, $password, $dbname);
        
                // Check the connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                 
                // Variable to track the status of form submission
                $formSubmitted = false;
                // Check if the form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Get the form data
                    $first_name = $_POST["firstname"];
                    $last_name = $_POST["lastname"];
                    $email = $_POST["email"];
                    $subject = $_POST["subject"];
                    $message = $_POST["message"];
        
                    // Insert the form data into the database
                    $sql = "INSERT INTO contact_messages (firstname, lastname, email, subject, message) VALUES ('$first_name', '$last_name', '$email', '$subject', '$message')";
        
                    if ($conn->query($sql) === TRUE) {
                        // Send the email
                        $to = "ndivajordan@gmail.com";
                        $mail->isHTML(true);
                        $mail->Subject = "New contact form submission";
                        $mail->Body = '<p>First Name: ' . $first_name . '<br/><br/>Last Name: ' . $last_name . '<br/><br/>Email: ' . $email . '<br/><br/>Subject: ' . $subject . '<br/><br/>Message: ' . $message . '</p>';
                        $mail->Headers = "From: $email";
                        // Set the 'From' header and sender name
                        $mail->setFrom($to, 'Elame Jordan');
                        // Set a custom 'Reply-To' address
                        $mail->addReplyTo($email, $first_name);
                        $mail->addAddress($to);
        
                  
                        if ($mail->send()) {
                          // Set the formSubmitted variable to true
                          $formSubmitted = true;
                          echo "<div class='alert alert-success w-50 text-center mt-5 mb-5 m-auto'>Message sent successfully!</div>";
                      } else {
                          echo "<div class='alert alert-danger w-50 text-center mt-5 mb-5 m-auto'>Failed to send message. Error: " . $mail->ErrorInfo . "</div>";
                      }
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                   
                }
        
                // Close the database connection
                $conn->close();
                ?>
        
             <?php if ($formSubmitted): ?>

            <?php else: ?> 

            <?php endif; ?>
        