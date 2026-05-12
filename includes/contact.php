<?php
error_reporting(0);
session_start(); // Start the session
// Check if user comming from a request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verify the token
    if (!empty($_POST["token"]) && hash_equals($_SESSION['token'], $_POST['token'])) {

        // Assign Variables
        $user = $_POST['name'];
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $tele = filter_var($_POST['telefoon'], FILTER_VALIDATE_INT);
        $msg = $_POST['message'];

        // Creating Array of Errors
        $formErrors = array();
        //String Validation  
        if (empty($_POST["name"])) {
            $formErrors[] = "Name is <strong>required</strong>";
        } else {
            $name = input_data($_POST["name"]);
            // check if name only contains letters and whitespace  
            if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                $formErrors[] = "Only <strong>alphabets</strong> and <strong>white space</strong> are allowed";
            }
        }

        //Email Validation   
        if (empty($_POST["email"])) {
            $formErrors[] = "Email is <strong>required</strong>";
        } else {
            $email = input_data($_POST["email"]);
            // check that the e-mail address is well-formed  
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $formErrors[] = "<strong>Invalid</strong> email format";
            }
        }

        // Number Validation  
        if (empty($_POST["telefoon"])) {
            $formErrors[] = "Mobile number is <strong>required</strong>";
        } else {
            $tele = input_data($_POST["telefoon"]);
            // check if mobile no is well-formed  
            if (!preg_match("/^((\+31)|(0031)|0)(\(0\)|)(\d{1,3})(\s|\-|)(\d{8}|\d{4}\s\d{4}|\d{2}\s\d{2}\s\d{2}\s\d{2})$/", $tele)) {
                $formErrors[] = "Not valid <strong>number.</strong>";
            }
            //check mobile no length should not be less and greator than 10  
            if (strlen($tele) <= 9) {
                $formErrors[] = "Mobile number must contain at least <strong>10</strong> digits.";
            }
        }
        if (empty($_POST["message"])) {
            $formErrors[] = "Message is <strong>Empty</strong>";
        } else {
            $msg = $_POST["message"];
        }


        // If no Errors send the email [mail(To, Subject, Message, Headers, Parameters)]
        $headers = 'From: ' . $email . ' (' . $user . ') (' . $tele . ')' . "\r\n";
        $headers .= 'X-Sender: ' . $email . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
        $headers .= 'Return-Path: ' . $email . "\r\n"; // Return path for errors
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=iso-8859-1' . "\r\n";
        $myEmail = 'kiosk-contact@kioskmaastricht.nl';
        $subject = 'Kiosk Contact Form';

        if (empty($formErrors)) {

            mail($myEmail, $subject, $msg, $headers);

            $user = '';
            $email = '';
            $tele = '';
            $msg = '';

            $success = '<div class="alert alert-success">We Have Recieved Your Message.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
    } else {
        $formErrors[] = "Invalid or missing token. This form submission may be a CSRF attack.";
    }
}
function input_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!-- Start-Contact-section -->
<section class="contact" id="contact">
    <h1 class="heading contact1"><span class="contact1"><?php echo $lang['contact span'] ?></span><?php echo $lang['contact h1'] ?></h1>
    <div class="row" data-aos="fade-left" data-aos-duration="1000" data-aos-offset="200" data-aos-delay="500">
        <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2519.2507112016424!2d5.694094015900669!3d50.84504146673449!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c0e9f858c0498d%3A0x236777db6886833e!2sKiosk%20Stadspark!5e0!3m2!1sen!2snl!4v1647794891369!5m2!1sen!2snl" allowfullscreen="" title="Kiosk-Stadpark"></iframe>
        <?php
        session_start();
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        ?>

        <form class="contact-form" id="captcha_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h3 class="heading" style="background: none;"><?php echo $lang['form h3'] ?> <span><?php echo $lang['form span'] ?></span></h3>

            <?php if (!empty($formErrors)) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    <?php
                    foreach ($formErrors as $error) {
                        echo $error . '<br/>';
                    }
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($success)) {
                echo $success;
            } ?>

            <fieldset class="inputBox">
                <input class="username form-control" type="text" placeholder="<?php echo $lang['form name'] ?>" value="<?php if (isset($user)) {
                                                                                                                            echo $user;
                                                                                                                        } ?>" name="name" />
                <span class="fas fa-user fa-fw"></span>

                <div class="alert alert-danger custom-alert">
                    Name can't be <strong>Empty,</strong> Or less than 3 <strong>Characters.</strong>
                </div>
            </fieldset>

            <fieldset class="inputBox">
                <input class="emailId form-control" type="email" placeholder="<?php echo $lang['form email'] ?>" value="<?php if (isset($email)) {
                                                                                                                            echo $email;
                                                                                                                        } ?>" name="email" />
                <span class="fas fa-envelope fa-fw"></span>

                <div class="alert alert-danger custom-alert">
                    Email can't be <strong>Empty.</strong>
                </div>
            </fieldset>

            <fieldset class="inputBox">
                <input class="telefon form-control" type="tel" placeholder="<?php echo $lang['form phone'] ?>" value="<?php if (isset($tele)) {
                                                                                                                            echo $tele;
                                                                                                                        } ?>" name="telefoon" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                <span class="fas fa-phone fa-fw"></span>

                <div class="alert alert-danger custom-alert">
                    Phone can't be <strong>Empty.</strong>
                </div>
            </fieldset>

            <fieldset class="inputBox">
                <textarea class="msg form-control" type="textarea" rows="5" placeholder="<?php echo $lang['form message'] ?>" name="message" style="width: 70%; height:100px;"><?php if (isset($msg)) {
                                                                                                                                                                                    echo $msg;
                                                                                                                                                                                } ?></textarea>
                <span class="fa fa-comment fa-fw comment"></span>

                <div class="alert alert-danger custom-alert">
                    Message can't be <strong>Empty,</strong> Or less than 8 <strong>Characters.</strong>
                </div>
            </fieldset>
            <input type="hidden" name="token" value="<?php echo $token; ?>" />
            <input class="btn btn-success rounded-pill" type="submit" name="submit" value="<?php echo $lang['form button'] ?>">
            </input>
        </form>
    </div>
</section>
<!-- End Contact Section -->