<?php 

$errorCount = 0;
$error = false;

$post = array(
    "edit"                 => isset($_POST["edit"])             ? true                : false,
    "link_name"        => isset($_POST["link_name"]) ? $_POST["link_name"] : "",
    "nick_name"        => isset($_POST["nick_name"]) ? $_POST["nick_name"] : "",
    "email"                => isset($_POST["email"])         ? $_POST["email"]         : "",
    "pass_old"        => isset($_POST["pass_old"])     ? $_POST["pass_old"]     : "",
    "pass"                => isset($_POST["pass"])             ? $_POST["pass"]             : "",
    "date_y"            => isset($_POST["date_y"])         ? $_POST["date_y"]         : "",
    "date_m"            => isset($_POST["date_m"])         ? $_POST["date_m"]         : "",
    "date_d"            => isset($_POST["date_d"])         ? $_POST["date_d"]         : "",
    "validate"        => isset($_POST["validate"])  ? $_POST["validate"]     : "",
    "terms"                => isset($_POST["terms"])          ? true                                 : false,
    "redirect"        => isset($_POST["redirect"])     ? $_POST["redirect"]     : "",
);

if ($R->user["logged"] != 1) {
    // If user is logged out, dump them
    header("Location: http://txm.com/misc/login/");
    exit;
} else if ($post["edit"] === true) {
    // Validate Link Name
    if ($post["link_name"] !== $R->user["linkName"]) {
        if (preg_match("/^[a-z0-9_-]{1,25}$/i", $post["link_name"]) !== 1) {
            setError("Your link name may only contain letters, numbers, '-', and '_'.");
        } else {
            $sql = "
                                SELECT
                                    id
                                FROM
                                    txm_users
                                WHERE
                                    link_name = '" . addslashes(strtolower($post["link_name"])) . "'
                            ";

            $result = $dbAdapter->query($sql);
            if ($result === false) {
                SITE_Log::error("Unable to retrieve link names.", $sql);
            } else if ($result->rowCount() > 0) {
                setError("The link name you provided is already being used.");
            } else {
                $sql = "
                                        SELECT
                                                id
                                        FROM
                                                reservednames
                                        WHERE
                                                name = '" . addslashes(strtolower($post["link_name"])) . "'
                                    ";

                $result = $dbAdapter->query($sql);

                if ($result === false) {
                    SITE_Log::error("Unable to retrieve reserved link names.", $sql);
                } else if ($result->rowCount() > 0) {
                    setError("The link name you provided is reserved by TXM.com.");
                }
            }
        }
    }

    // Validate Nick Name
    if (empty($post["nick_name"]) === true || strlen($post["nick_name"]) > 25) {
        setError("Your nick name must be between 1 and 25 characters.");
    }

    // Validate Email
    if (preg_match("/^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@([a-z0-9]([a-z0-9-]*[a-z0-9])?\.)+[a-z0-9]([a-z0-9-]*[a-z0-9])?$/i", $post["email"]) !== 1) {
        setError("Please provide a valid email address. TXM.com does not support quotes or brackets.");
    } else {
        // Check if domain is valid (apache only)
        $domain = substr($post["email"], strpos($post["email"], "@") + 1);

        if (checkdnsrr($domain . ".", "MX") === FALSE && checkdnsrr($domain . ".", "A") === false) {
            setError("The email domain you provided is not recognized by TXM.com.");
        } else {
            // Check if email person is entering is already used by someone else
            $sql = "
                                    SELECT
                                            id,
                                            deleted
                                    FROM
                                            txm_users
                                    WHERE
                                            id <> " . intval($R->user["id"]) . " AND
                                            email = '" . addslashes(strtolower($post["email"])) . "'
                            ";

            $result = $dbAdapter->query($sql);
            if ($result === false) {
                SITE_Log::error("We were unable to retrieve email information.", $sql);
            } else if ($result->rowCount() > 0) {
                setError("The email you provided is already in use.");
            }
        }
    }

    if (empty($post["pass_old"]) === true) {
        setError("You must provide your current password.");
    } else {
        $sql = "
                            SELECT
                                    id
                            FROM
                                    txm_users
                            WHERE
                                    id = " . intval($R->user["id"]) . " AND
                                    password = '" . md5($post["pass_old"]) . "'
                    ";

        $result = $dbAdapter->query($sql);
        if ($result === false) {
            SITE_Log::error("We were unable to retrieve password information.", $sql);
        } else if ($result->rowCount() === 0) {
            setError("Your old password is invalid.");
        }
    }

    // Check for old password
    if (empty($post["pass"]) === false) {
        if (strlen($post["pass"]) < 6 || strlen($post["pass"]) > 16) {
            setError("Your new password must be 6 to 16 characters.");
        }
    }

    // Validate Birth Date
    if (checkdate(intval($post["date_m"]), intval($post["date_d"]), intval($post["date_y"])) === false) {
        setError("Please provide a valid birth date.");
    } else if (intval(date("Ymd")) - 130000 < intval($post["date_y"] . $post["date_m"] . $post["date_d"])) {
        setError("You must be at least 13 years old.");
    }

    // Update account
    if ($error === false) {
        $sql = "
                            UPDATE
                                    txm_users
                            SET
                                    " . (empty($post["pass"]) === false ? "password  = '" . md5($post["pass"]) . "'," : "") . "
                                    link_name = '" . addslashes(strtolower($post["link_name"])) . "',
                                    nick_name = '" . addslashes($post["nick_name"]) . "',
                                    email     = '" . addslashes(strtolower($post["email"])) . "',
                                    date_born = '" . date("Y-m-d", strtotime($post["date_y"] . "-" . $post["date_m"] . "-" . $post["date_d"])) . "'
                            WHERE
                                    id = " . intval($R->user["id"]) . "
                    ";

        if ($dbAdapter->query($sql) === false) {
            SITE_Log::error("Unable to edit account.", $sql);
        } else {
            $template->setSwitch("edit_success");
        }
    }
}

if ($error === true || $post["edit"] === false) {
    if ($post["edit"] === false) {
        $sql = "
                            SELECT
                                    link_name,
                                    nick_name,
                                    email,
                                    YEAR(date_born) AS date_y,
                                    MONTH(date_born) AS date_m,
                                    DAY(date_born) AS date_d
                            FROM
                                    txm_users
                            WHERE
                                    id = " . intval($R->user["id"]) . "
                    ";

        $result = $dbAdapter->query($sql);
        if ($result === false) {
            SITE_Log::error("We were unable to retrieve profile information.", $sql);
        } else if ($result->rowCount() === 0) {
            setError("We are unable to retrieve your profile information.");
        } else {
            $post = $result->fetch();
        }
    }

    $date = date_options($post['date_y'], $post["date_m"], $post["date_d"], date('Y') - 120, 120);
    $template->addBlock("edit", array(
                        "link_name"            => $post["link_name"],
                        "nick_name"            => $post["nick_name"],
                        "email"                    => $post["email"],
                        "date_y"                => $date["y"],
                        "date_m"                => $date["m"],
                        "date_d"                => $date["d"],
    ));
}

// Generate the page
$template->setView('body', 'editaccount');
$R->pageTitle = 'Indie Flash Movies &amp; Games';

function date_options($year, $month, $day, $start, $offset)
{
    $strYear = '';
    for ($i = $start; $i <= $start + $offset; $i++) {
        $strYear .= '<option value="' . $i . '"' . ($i == $year ? ' selected="selected"' : '') . '>' . $i . '</option>';
    }

    $strMonth = '';
    for ($i = 1; $i <= 12; $i++) {
        $strMonth .= '<option value="' . $i . '"' . ($i == $month ? ' selected="selected"' : '') . '>' . date('M', strtotime('2009-' . $i . '-01')) . '</option>';
    }

    $strDay = '';
    for ($i = 1; $i <= 31; $i++) {
        $strDay .= '<option value="' . $i . '"' . ($i == $day ? ' selected="selected"' : '') . '>' . date('jS', strtotime('2009-01-' . $i)) . '</option>';
    }    

    return array('y' => $strYear, 'm' => $strMonth, 'd' => $strDay);
}

function setError($errorMsg) {
    global $template, $errorCount, $error;
    
    if ($errorCount === 0) {
        $template->setSwitch("edit_errors");
        $error = true;
    }

    $template->addBlock("edit_errors.row", array(
                        "class"   => ($errorCount++ % 2 === 0 ? "grn-alt" : ""),
                        "message" => $errorMsg,
    ));

    return true;
}
