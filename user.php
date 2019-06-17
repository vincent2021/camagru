<?php 
require_once  'header.php';
require_once 'class/userClass.php';
$userClass = new userClass();
$fdbk = "";
if (isset($_SESSION['uid'])) {
    $data = $userClass->userDetail($_SESSION['uid']);
} else {
    header('Location: login.php');
}
if (isset($_POST)) {
    foreach($_POST as $value) {
        $value = htmlspecialchars($value);
    }
    if (isset($_POST['full_name'])){
        $fdbk = "New name is ".$_POST['full_name'];
    }
}
?>
<body>
<div class="section">
    <h1 class="title">User Details</h1>
    <div class="label">Name</div> <input class="input" value="<?=$data[0]?>" type="text" id="full_name" name="full_name" readonly/> <br>
    <div class="control"><br><input class="button is-primary" id="changename" type="submit" name="changename" onclick="changeName()" value="Change your name" ></div> <br>
    <?=$fdbk?>
    <div class="label">Email</div> <input class="input" value="<?=$data[1]?>" type="email" id="email" name="email" readonly/><br>
    <div class="control"><br><input class="button is-primary" id="changeemail" type="submit" name="changeemail" value="Change your email" onclick="changeEmail()"></div>
    <br>
    <h1 class="title">Change your password</h1>
    <form class="form" method="POST" action="user.php" >
        <div class="label">Old password</div> <input class="input" value="" type="passwd" id="oldpw" name="oldpw" value=""/> <br>
        <div class="label">New password</div> <input class="input" value="" type="passwd" id="newpw" name="newpw" value=""/> <br>
        <div class="label">Confirm your new password</div> <input class="input" value="" type="passwd" id="newpw" name="newpw2" value=""/> <br>
        <br><div class="control"><input class="button is-danger" id="changepasswd" type="submit" name="changepasswd" value="Change your password"></div>
    </form>
</div>
<script type="text/javascript">
function changeName() {
    if (document.getElementById("full_name").readOnly == false) {
        var form = new FormData();
        form.append('full_name', document.getElementById('full_name').value);
        postData(form);
        document.getElementById("full_name").readOnly = true;
        document.getElementById("changename").value = "Done";
        document.getElementById("changename").className = "button is-primary";
    } else {
        document.getElementById("full_name").readOnly = false;
        document.getElementById("changename").value = "Confirm";
        document.getElementById("changename").className = "button is-danger";
    }
}

function changeEmail() {
    if (document.getElementById("email").readOnly == false) {    
        var form = new FormData();
        form.append('email', document.getElementById("email").value);
        postData(form);
        document.getElementById("full_name").readOnly = true;
        document.getElementById("changename").value = "Done";
        document.getElementById("changename").className = "button is-primary";
    } else {
        document.getElementById("email").readOnly = false;
        document.getElementById("changeemail").value = "Confirm";
        document.getElementById("changeemail").className = "button is-danger";
    }
}

function postData(form) {
    var req = new XMLHttpRequest;
    req.onreadystatechange = function() {
        if(req.readyState == 4 && req.status == 200) {
            alert(req.response);
        }
    }
    req.open("POST", 'user_mgmt.php');
    req.send(form);
}
</script>
</body>
<?php require_once 'footer.php';?>