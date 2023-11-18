  <?php
       if (isset($_POST["login"])){
        $eMail = $_POST["email"];
        $cardNumber = $_POST["cardnumber"];
        $password = $_POST["password"];
        require_once "database.php";
        $sql = "SELECT * FROM bank_reg WHERE email = '$eMail' AND cardnumber = '$cardNumber'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if($user){
           if(password_verify($password, $user["password"])){
              //session_start();
              //$_SESSION["user"] = "yes";
              header("location: index.html");
              die();
           }else{
              echo "<div class='alert alert-danger'>Password does not match</div>";
           }
        }else{
           echo "<div class='alert alert-danger'>Incorrect cardnumber or Email</div>";
        }

      }
      
   ?> 