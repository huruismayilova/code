<?php 
session_start();
include '../includes/header.php';  
include '../config/database.php';  
include '../helper/helper.php';  
include '../includes/navbar.php'; 
include '../includes/footer.php'; 

$errors=[];
if($_SERVER['REQUEST_METHOD']=='POST'){
    $errors=validation(['otp']);

    if(count($errors)==0){
        $otp=post('otp');
        $comfirmation_otp=$_SESSION['otp'];
        $otp_ttl=$_SESSION['otp_ttl'];
        $user_email=$_SESSION['otp_email'];

        if(time()<=$otp_ttl){

            if($otp==$comfirmation_otp){

                $sql="UPDATE users SET otp=NULL WHERE email=?";
                $updateQuery=$conn->prepare($sql);
                $check=$updateQuery->execute([
                    $user_email
                ]);

                if($check){
                    $_SESSION=[];
                    header("location: http://localhost/final-project/auth/login.php");
                }
            }
        }
    }
}
?>
<form action="" method="post">
<label for="otp">Add OPT code</label>
    <input type="text" name="otp" id="otp">
    <?php
            if (isset($errors['otp'])) {
            ?>
                <span class='error'><?php echo $errors['otp']; ?> </span>
            <?php
            }
            ?>
            <button >Submit</button>
</form>