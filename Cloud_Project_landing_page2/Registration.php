      <?php
   if(isset($_POST["submit"])){
    
    $userName = $_POST["username"];
    $eMail = $_POST["email"];
    $cardNumber = $_POST["cardnumber"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["repeat_password"];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $passwordHashtwo = password_hash($confirmPassword, PASSWORD_DEFAULT);
    $errors = array();

    if(empty($userName) OR empty($eMail) OR empty($password) OR empty($confirmPassword) ){
        array_push($errors,"All fields are required");
    }

    if(!filter_var($eMail, FILTER_VALIDATE_EMAIL)){
        array_push($errors, "Email is not valid");
    }

    
    if(strlen($cardNumber)<16){
        array_push($errors, "Card number must be 18 digits long");
    }

    if(strlen($password)<8){
        array_push($errors, "Password must be atleast 8 characteres long");
    }

    if($password!==$confirmPassword){
        array_push($errors, "Password does not match");
    }
    //We need to connect to the database before checking if the email entered already exists
    require_once "database.php";
    $sql = "SELECT * FROM bank_reg WHERE email='$eMail'";
    $result = mysqli_query($conn, $sql);
    $rowCount = mysqli_num_rows( $result);

    $sql2 = "SELECT * FROM bank_reg WHERE cardnumber='$cardNumber'";
    $result2 = mysqli_query($conn, $sql2);
    $rowCount2 = mysqli_num_rows($result2);

    if($rowCount>0){

        array_push($errors, "Email already exists");
    }

    if($rowCount2>0){

        array_push($errors, "Bank Card in use already");
    }

    if(count($errors)>0){

        foreach($errors as $error){
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }else{

        // we will insert the data into the database table bank_reg
        
        $sql = 'INSERT INTO bank_reg(username, email, cardnumber, password) VALUES(?, ?, ?, ?)';
        $stmt = mysqli_stmt_init($conn);
        $preparestmt = mysqli_stmt_prepare($stmt,$sql);

        if($preparestmt){

            mysqli_stmt_bind_param($stmt,"ssss",$userName,$eMail,$cardNumber,$passwordHash);
            mysqli_stmt_execute($stmt);
            echo "<alert alert-success>You are registered successfully";
            header("location: Login.php");
        }else{
          
            die("Something went wrong");
        }
    }
}
?> 