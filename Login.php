<div id="login-box" class="" style="place-items: center;">
    <h2>Login Here</h2>
    <?php
        if(isset($_POST['submit'])){
            $us =$_POST['IN_username'];
            $pa=$_POST['IN_password'];
            include_once("connection.php");
            // Escape special characters in a string
            $us = mysqli_real_escape_string($conn, $us);
            $pa = mysqli_real_escape_string($conn, $pa);
            $encrypted_password = password_hash($pa, PASSWORD_DEFAULT);
            $sq="select * from user where username='$us'";
            $res= mysqli_query($conn,$sq) or die(mysqli_error($conn));
            $row=mysqli_fetch_array($res,MYSQLI_ASSOC);
            if(mysqli_num_rows($res)==1) {
                $encrypted_password = $row['password'];
                if (password_verify($pa, $encrypted_password)) {
                    // mật khẩu hợp lệ
                    $_SESSION["us"]=stripslashes($us);
                    $_SESSION["us_id"]=$row['id'];
                    echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';
                } else {
                    // mật khẩu không hợp lệ
                    echo "Password is incorrect, please login again";
                }
            } else {
                // mật khẩu không hợp lệ
                echo "Username or password is incorrect, please login again";
            }
        }
    ?>
    <form method="POST">
        <p>Username</p>
        <input type="text" id="IN_username" name="IN_username" required placeholder="Enter Username">
        <p>Password</p>
        <input type="password" id="IN_password" name="IN_password" required placeholder="Enter Password">
        <input type="submit" name="submit" id="btnLogin" value="Login">
        <a href="#">Forgot Password</a>
    </form>
</div>
