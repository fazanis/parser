<?php
include_once 'config.php';

$row = 1;
if (($handle = fopen("test.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data);
        echo "<p> $num полей в строке $row: <br /></p>\n";
        $row++;
        $str = $data[0] . ' ' . $data[1] . ' ' . $data[2];
        $array = [$str, $data[3], $data[4]];

        $dateRegistr = strtotime($array[2]);
        $datenew = date('Y-m-d', $dateRegistr) . ' 15:04:00';

        $params = '{"admin_style":"","admin_language":"en-GB","language":"en-GB","editor":"","helpsite":"","timezone":""}';
        $block = 0;
        $sendEmail = 0;
        $lastvisitDate = '0000-00-00 00:00:00';
        $password = md5('12345');
        $lastResetTime = '0000-00-00 00:00:00';
        $resetCount  = '0';
        $db = Db::getConnection();
        $sql = 'INSERT INTO kx4i8_users (name, username, email, password, block, sendEmail, registerDate, lastvisitDate, activation, params, lastResetTime) VALUES 
(:name, :username, :email, :password,:block, :sendEmail, :registerDate, :lastvisitDate, "", "", :lastResetTime)';
        $result = $db->prepare($sql);
        $result->bindParam(':name', $array[0], PDO::PARAM_STR);
        $result->bindParam(':username', $array[0], PDO::PARAM_STR);
        $result->bindParam(':email', $array[1], PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->bindParam(':block', $block);
        $result->bindParam(':sendEmail', $sendEmail);
        $result->bindParam(':registerDate', $datenew);
        $result->bindParam(':lastvisitDate', $datenew);
        $result->bindParam(':lastResetTime', $datenew);
        $result->execute();

    }
    fclose($handle);
}
