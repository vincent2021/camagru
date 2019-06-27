<?php 
require_once  'header.php';
require_once 'class/userClass.php';
$userClass = new userClass();
unset($fdbk);
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
    } else if (isset($_POST['email'])){
        $fdbk = "New email is ".$_POST['email'];
    } else if (isset($_POST['oldpw']) && isset($_POST['newpw']) && isset($_SESSION['uid'])) {
        $new_pw = hash('whirlpool', $_POST['newpw']);
        $old_pw = hash('whirlpool', $_POST['oldpw']);
        $fdbk = $userClass->userChangePasswd($old_pw, $new_pw);
    }
}
?>
<body>
<div class="section">
    <h1 class="title">User Details</h1>
    <?php if (isset($fdbk)) { echo '<script>alert("'.$fdbk.'")</script>';}?>
    <div class="label">Name</div> <input class="input" value="<?=$data[0]?>" type="text" id="full_name" name="full_name" readonly/> 
    <p class="help">Minimum length is 3.</p>
    <div class="control"><br><input class="button is-primary" id="changename" type="submit" name="changename" onclick="changeName()" value="Change your name" ></div> <br>
    <div class="label">Email</div> <input class="input" value="<?=$data[1]?>" type="email" id="email" name="email" readonly/><br>
    <div class="control"><br><input class="button is-primary" id="changeemail" type="submit" name="changeemail" value="Change your email" onclick="changeEmail()"></div>
    <br>
    <h1 class="title">Alerts</h1>
    <form id="alertForm" class="form" method="POST" action="user.php" >
        <label class="checkbox"><input <?php if($data['alert'] == 1) {echo 'checked value="1"';} else {echo 'value="0"';}?> id="alert" name="alert" onclick="changeAlert()" type="checkbox" value=""> Alert me when someone post a comment on my pictures</label>
    </form><br><br>
    <h1 class="title">Change your password</h1>
    <form class="form" method="POST" action="user.php" >
        <div class="label">Old password</div> <input class="input" value="" type="password" id="oldpw" autocomplete="current-password" name="oldpw" value=""/> <br>
        <div class="label">New password</div> <input class="input" value="" type="password" id="newpw" autocomplete="new-password" name="newpw" value=""/>
        <p class="help">Password must contains at least one letter and one number. Minimum length is 6.</p><br>
        <div class="label">Confirm your new password</div> <input class="input" value="" type="password" id="newpw2" autocomplete="new-password" name="newpw2" value=""/> <br>
        <br><div class="control"><input class="button is-danger" id="changepasswd" type="submit" name="changepasswd" value="Change your password"></div>
    </form><br>
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
    if (document.getElementById("email").readOnly = false) {    
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

function changeAlert() {
    var form = new FormData();
    if (document.getElementById("alert").checked) {    
        form.append('alert', 1);
    } else {
        form.append('alert', 0);
    }
    postData(form);
}

function postData(form) {
    var xhr = new XMLHttpRequest;
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            $ret = xhr.response;
            alert($ret);
        }
    }
    xhr.open("POST", 'user_mgmt.php');
    xhr.send(form);
}
</script>
</body>
<?php require_once 'footer.php';?>