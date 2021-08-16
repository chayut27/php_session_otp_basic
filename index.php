<?php
session_start();


$type = "gen_otp";
$post_otp = "";

switch ($type) {
    case "gen_otp":
        $otp = rand(10000, 999999);
        $expire = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        $_SESSION["otp"] = $otp;
        $_SESSION["expire"] = $expire;
        break;
    case "verify_otp":
        if (!empty($_SESSION["otp"])) {
            if ($_SESSION["expire"] >= date('Y-m-d H:i:s')) {
                if ($post_otp == $_SESSION["otp"]) {
                    unset($_SESSION['otp']);
                    unset($_SESSION['expire']);
                    echo json_encode(array("type" => "success", "message" => "Your OTP is verified!"));
                } else {
                    echo json_encode(array("type" => "error", "message" => "OTP verification failed"));
                }
            } else {
                echo json_encode(array("type" => "error", "message" => " This otp has expired."));
            }
        } else {
            echo json_encode(array("type" => "error", "message" => "OTP verification failed"));
        }
        break;

    default:
        echo json_encode(array("type" => "error", "message" => "OTP verification failed"));
}
