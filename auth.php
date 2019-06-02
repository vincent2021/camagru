<?php function auth($login, $password) {
    if (!isset($login) || !isset($password))
        return 0;
    $folder = "../private";
    $file = $folder."/passwd";
    if (file_exists($file)) {
        $read = unserialize(file_get_contents($file));
        if (isset($read[$login]) && $read[$login]['passwd'] == hash('whirlpool', $password)) {
            return 1;
        }
    }
    return 0;
}
function whoami() {
    if (isset($_SESSION['loggued_on_user'])) {
        return $_SESSION['loggued_on_user'];
    } else {
        return "Please connect\n";
    }
} ?>