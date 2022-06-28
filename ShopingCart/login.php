<html>
<title>登录</title>
<meta charset="utf-8">
<form action="login.php" method="post" onsubmit="return checkall()">
    <h1>用户登录</h1>
    <table width="900">
        <tr>
            <td>用户名：<input type="text" id="username" name="username" onblur="checkuser()"></td>
        </tr>
        <tr>
            <td id="usernametip"></td>
        </tr>
        <tr>
            <td>密码：<input type="password" id="password" name="password" onblur="checkpwd()"></td>
        </tr>
        <tr>
            <td id="passwordtip"></td>
        </tr>
        <tr>
            <td><input type="submit" value="登录"></td>
            <td><input type="reset" value="重新填写"></td>
        </tr>
        <tr>
            <td>
                <?PHP
                header("Content-type:text/html;charset=utf-8");
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    session_start();
                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    $sername = "localhost";
                    $serusername = "root";
                    $serpassword = "";
                    $serdb = "minishop";

                    $conn = mysqli_connect($sername, $serusername, $serpassword, $serdb);
                    if (!$conn) {
                        echo "连接数据库失败";
                    }
                    $conn->set_charset("utf-8");

                    $search = "select * from user where username = '" . $username . "' and password = '" . $password . "';";
                    $result = $conn->query($search);
                    $userdata = $result->fetch_all();

                    if ($userdata == NULL) {
                        echo "<font color=red>用户名或密码错误</font>";
                    } else {
                        header("refresh:0,url=login_success.php");
                        $_SESSION["user"] = $username;
                    }
                }
                ?>
            </td>
        </tr>
    </table>
    <td><a href="register.php">没注册？点我注册</a>
</form>

</html>

<script type="text/javascript">
    function $(elementID) {
        return document.getElementById(elementID);
    }

    function checkuser() {
        var userdata = $("username").value;
        var reg = /^\w{4,15}$/;
        var usertip = $("usernametip");
        usertip.innerHTML = "";

        if (reg.test(userdata) == false) {
            usertip.innerHTML = ("<font color=red>用户名格式不正确，应为4-15位</font>");
            return false;
        }
        usertip.innerHTML = "";
        return true;
    }

    function checkpwd() {
        var pwd = $("password").value;
        var pwdtip = $("passwordtip");
        pwdtip.innerHTML = "";
        var reg = /[a-zA-Z0-9]{6,16}$/

        if (reg.test(pwd) == false) {
            pwdtip.innerHTML = "<font color=red>密码格式不正确，应为6至16位</font>";
            return false;
        }
        pwdtip.innerHTML = "";
        return true;
    }

    function checkall() {
        if (checkuser() && checkpwd() == true) {
            return true;
        } else {
            checkuser();
            checkpwd();
            return false;
        }
    }
</script>