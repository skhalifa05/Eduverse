<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

Class Email {
    /**
     * @var String
     */
    /**
     * @var String
     */
    /**
     * @var String
     */
    private String $Admin_email, $Admin_name, $Admin_pwd;

    /**
     * @param String $Admin_email
     * @param String $Admin_name
     * @param String $Admin_pwd
     */
    public function __construct(string $Admin_email, string $Admin_name, string $Admin_pwd)
    {
        $this->setAdminEmail($Admin_email);
        $this->setAdminName($Admin_name);
        $this->setAdminPwd($Admin_pwd);
    }

    /**
     * @return String
     */
    public function getAdminName(): string
    {
        return $this->Admin_name;
    }

    /**
     * @param String $Admin_name
     */
    public function setAdminName(string $Admin_name): void
    {
        $this->Admin_name = $Admin_name;
    }

    /**
     * @return String
     */
    public function getAdminPwd(): string
    {
        return $this->Admin_pwd;
    }

    /**
     * @param String $Admin_pwd
     */
    public function setAdminPwd(string $Admin_pwd): void
    {
        $this->Admin_pwd = $Admin_pwd;
    }

    /**
     * @return String
     */
    public function getAdminEmail(): string
    {
        return $this->Admin_email;
    }

    /**
     * @param String $Admin_email
     */
    public function setAdminEmail(string $Admin_email): void
    {
        $this->Admin_email = $Admin_email;
    }

    /**
     * @return PHPMailer
     */
    public function SetupEmailSending():PHPMailer
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'localhost';
        $mail->SMTPAuth = true;
        $mail->SMTPAutoTLS = false;
        $mail->SMTPSecure = "ssl";
        $mail->Port       = 465;
        $mail->Host       = "smtp.titan.email";
        $mail->Username   = $this->getAdminEmail();
        $mail->Password   = $this->getAdminPwd();
        $mail->IsHTML(true);
        return $mail;
    }

    /**
     * @param string $Lecture_name
     * @param string $Course_name
     * @param String $lecture_time
     * @param string $st_name
     * @param string $st_email
     * @param String $arrival_time
     * @return bool
     */
    public function StudentAttendNotification(string $Lecture_name, string $Course_name, String $lecture_time, string $st_name, string $st_email, String $arrival_time): bool
    {
        date_default_timezone_set('Africa/Cairo');
        $mail = $this->SetupEmailSending();
        try {
            $mail->AddAddress($st_email, $st_name);
        } catch (Exception ) {
            return false;
        }
        try {
            $mail->SetFrom($this->getAdminEmail(), $this->getAdminName());
        } catch (Exception ) {
            return false;
        }
        $mail->Subject = "Attendance update";
        $content = '<table style="width: 100%;display: flex;flex-direction: column;align-items: center;"><tbody><tr><td style="text-align: center;"><img src="https://brightside-edu.com/Images/BrightSideLogo.png" style="width:30%;margin:5%;" alt=""></td></tr><tr><td style="border: none;border-top:3px solid #19e402;box-shadow: #e0e0e0 0 5px 15px;padding: 5%;margin: 0 3% 3% 3%;width: 80%;"><p style="font-size: 18px;line-height: 23px;color: #102231;font-family: \'Open+Sans\', \'Open Sans\', Helvetica, Arial, sans-serif;"><strong>Hi ' . $st_name . ',</strong></p><br><p style="color: #525C65;font-size: 14px;font-family: \'Open+Sans\', \'Open Sans\', Helvetica, Arial, sans-serif;line-height: 24px">You attended ' . $Lecture_name . ',<br>' . $Course_name . '</p><br><p style="color: #525C65;font-family: \'Open+Sans\', \'Open Sans\', Helvetica, Arial, sans-serif;font-size: 14px;line-height: 24px;"><strong>Date: ' . date('d/m/Y', time()) . '<br>Lecture time: ' . $lecture_time . '<br>Time of attendance: ' . $arrival_time . '</strong></p><br><p style="margin: 0;font: bold 14px/16px Arial, Helvetica, sans-serif;color: #363636;padding: 0 0 7px;">Best of luck!</p></td></tr><tr><td style="padding: 10px 0;border-bottom: 1px solid #e5ebef;width:65%;"></td></tr><tr><td style="text-align: center;"><img src="https://brightside-edu.com/Images/mail_logo.png" alt="" style="margin-top: 10px;width:60%"></td></tr></tbody></table>';
        try {
            $mail->MsgHTML($content);
        } catch (Exception ) {
            return false;
        }
        try {
            if (!$mail->Send()) {
                return false;
            } else {
                return true;
            }
        } catch (Exception ) {
            return false;
        }
    }



    public function ramyattend(string $st_name, string $st_email): bool
    {
        date_default_timezone_set('Africa/Cairo');
        $mail = $this->SetupEmailSending();
        $mail->addBCC('support@codeology.digital');
        try {
            $mail->AddAddress($st_email, $st_name);
        } catch (Exception ) {
            return false;
        }
        try {
            $mail->SetFrom($this->getAdminEmail(), $this->getAdminName());
        } catch (Exception ) {
            return false;
        }
        $mail->Subject = "Dr Ramy's Ramadan Sohour Night";
        $content = '<table style="width: 100%;display: flex;flex-direction: column;align-items: center;"><tbody><tr><td style="text-align: center;"><img src="https://brightside-edu.com/Images/BrightSideLogo.png" style="width:30%;margin:1%;" alt=""><br><img src="https://brightside-edu.com/Images/lockup.png" style="width:80%;margin:1%;" alt=""></td></tr><tr><td style="border: none;border-top:3px solid #19e402;box-shadow: #e0e0e0 0 5px 15px;padding: 5%;margin: 0 3% 3% 3%;width: 80%;"><p style="font-size: 18px;line-height: 23px;color: #102231;font-family: \'Open+Sans\', \'Open Sans\', Helvetica, Arial, sans-serif;"><strong>Hi ' . $st_name . ',</strong></p><p style="font-size: 18px;line-height: 23px;color: #102231;font-family: \'Open+Sans\', \'Open Sans\', Helvetica, Arial, sans-serif;"><strong>Thank you for registering for Dr. Ramy&apos;s Sohour night, we cant wait to see you!<br><br>For cancellations please send an email to geeksupport@codeology.digital stating your name, email and phone number.<br><br>A quick message from Dr.Ramy,</strong></p><p style="font-size: 18px;line-height: 23px;color: #102231;font-family: \'Open+Sans\', \'Open Sans\', Helvetica, Arial, sans-serif;">My sohour invitation limited to my students only!<br> There will be on ground registration at the hotel to make sure the attendees are my students.<br>To avoid any conflicts or embarrassment, read the below carefully:<br>-Entrance is from the reception&apos;s main gate only.<br>-If the student&apos;s name is not registered through the link prior the event, or not registered with me in accounting, the student will not be allowed to attend the sohour. ( NO EXCEPTIONS)<br>-Door will be closed at 10:00 pm<br>-The winners must be present in the event in order to get their prize.<br>-please be cooperative with the registration team, so that we would start the event smoothly.<br>Waiting for you Tomorrow, at 9:00 pm in Helnan Landmark Hotel!<br>Ramadan Kareem.</p><br><p style="margin: 0;font: bold 14px/16px Arial, Helvetica, sans-serif;color: #363636;padding: 0 0 7px;">Regards,<br>Dr. Ramy Mahfouz</p></td></tr><tr><td style="padding: 10px 0;border-bottom: 1px solid #e5ebef;width:65%;"></td></tr><tr><td style="text-align: center;"><img src="https://brightside-edu.com/Images/cocom.png" alt="" style="margin-top: 10px;width:60%"></td></tr></tbody></table>';
        try {
            $mail->MsgHTML($content);
        } catch (Exception ) {
            return false;
        }
        try {
            if (!$mail->Send()) {
                return false;
            } else {
                return true;
            }
        } catch (Exception ) {
            return false;
        }
    }

    /**
     * @param string $Lecture_name
     * @param string $Course_name
     * @param string $st_name
     * @param string $st_email
     * @return bool
     */
    public function StudentAbsentNotification(string $Lecture_name, string $Course_name, string $st_name, string $st_email): bool
    {
        date_default_timezone_set('Africa/Cairo');
        $mail = $this->SetupEmailSending();
        try {
            $mail->AddAddress($st_email, $st_name);
        } catch (Exception ) {
            return false;
        }
        try {
            $mail->SetFrom($this->getAdminEmail(), $this->getAdminName());
        } catch (Exception ) {
            return false;
        }
        $mail->Subject = "Attendance update";
        $content = '<table style="width: 100%;display: flex;flex-direction: column;align-items: center;"><tbody><tr><td style="text-align: center;"><img src="https://brightside-edu.com/Images/BrightSideLogo.png" style="width:30%;margin:5%;" alt=""></td></tr><tr><td style="border: none;border-top:3px solid #e40202;box-shadow: #e0e0e0 0 5px 15px;padding: 5%;margin: 0 3% 3% 3%;width: 80%;"><p style="font-size: 18px;line-height: 23px;color: #102231;font-family: \'Open+Sans\', \'Open Sans\', Helvetica, Arial, sans-serif;"><strong>Hi ' . $st_name . ',</strong></p><br><p style="color: #525C65;font-size: 14px;font-family: \'Open+Sans\', \'Open Sans\', Helvetica, Arial, sans-serif;line-height: 24px">You have missed ' . $Lecture_name . ',<br>' . $Course_name . '</p><br><p style="color: #525C65;font-family: \'Open+Sans\', \'Open Sans\', Helvetica, Arial, sans-serif;font-size: 14px;line-height: 24px;"><strong>Date: ' . date('d/m/Y', time()) . '</strong></p><br><p style="color: #525C65;    font-family: \'Open+Sans\', \'Open Sans\', Helvetica, Arial, sans-serif;font-size: 14px;line-height: 24px;margin: 0 0 10px;">Please reply to this email with your excuse even if you informed your Teacher/Center</p><p style="font: bold 14px/16px Arial, Helvetica, sans-serif;color: #363636;padding:  0 0 7px;margin: 40px 0 0;">Please avoid missing your lecture to prevent any struggles</p></td></tr><tr><td style="padding: 10px 0;border-bottom: 1px solid #e5ebef;width:65%;"></td></tr><tr><td style="text-align: center;"><img style="margin-top: 10px;width:60%" src="https://brightside-edu.com/Images/mail_logo.png" alt=""></td></tr></tbody></table>';
        try {
            $mail->MsgHTML($content);
        } catch (Exception ) {
            return false;
        }
        try {
            if (!$mail->Send()) {
                return false;
            } else {
                return true;
            }
        } catch (Exception ) {
            return false;
        }
    }

    /**
     * @param string $email
     * @param string $name
     * @param int $student_id
     * @return bool
     */
    public function SendStudentVerificationEmail(string $email, string $name, int $student_id): bool
    {
        $mail = $this->SetupEmailSending();
        try {
            $mail->AddAddress($email, $name);
        } catch (Exception ) {
            return false;
        }
        try {
            $mail->SetFrom($this->getAdminEmail(), $this->getAdminName());
        } catch (Exception ) {
            return false;
        }
        $mail->Subject = "Activation Code";
        $content = '<table style="width: 100%;"><tbody><tr><td style="text-align: center;"><img src="https://brightside-edu.com/Images/BrightSideLogo.png" style="width:30%;margin:5%;" alt=""></td></tr><tr><td style="border: none;border-top:3px solid #02b3e4;box-shadow: #e0e0e0 0 5px 15px;padding: 5%;margin: 0 3% 3% 3%;width: 70%;"><p style="font-size: 18px;line-height: 23px;color: #102231;font-family: \'Open+Sans\', \'Open Sans\', Helvetica, Arial, sans-serif;"><strong>Dear ' . $name . ',</strong></p><br><p style="color: #525C65;font-size: 14px;font-family: \'Open+Sans\', \'Open Sans\', Helvetica, Arial, sans-serif;line-height: 24px">please verify your email to use your codeology education account and track you progress</p><br><div style="text-align: center;"><a href="https://brightside-edu.com/Controller/Verify_Email.php?Student_Email_Verify&Email=' . $email . '&Student_ID=' . $student_id . '" target="_blank" style="background-color:#01b3e3; border-collapse:separate !important; border-top:10px solid #01b3e3; border-bottom:10px solid #01b3e3; border-right:45px solid #01b3e3; border-left:45px solid #01b3e3; border-radius:4px; color:#ffffff; display:inline-block; font-family:\'Open+Sans\',\'Open Sans\',Helvetica, Arial, sans-serif; font-size:13px; font-weight:bold; text-align:center; text-decoration:none; letter-spacing:2px;">VERIFY EMAIL</a></div><div style="padding: 10px 0;border-bottom: 1px solid #e5ebef;width:100%;"></div><br><p style="font:14px/16px Arial, Helvetica, sans-serif; color:#363636; margin:1em 1em 0 0;">Your Computer Geeks,</p><p style="margin: 0;font: bold 14px/16px Arial, Helvetica, sans-serif;color: #363636;padding: 0 0 7px;">Codeology Education Team</p></td></tr><tr><td style="padding: 10px 0;border-bottom: 1px solid #e5ebef;width:65%;"></td></tr><tr><td style="text-align: center;"><img src="https://brightside-edu.com/Images/mail_logo.png" alt="" style="margin-top: 10px;width:60%"></td></tr></tbody></table>';
        try {
            $mail->MsgHTML($content);
        } catch (Exception ) {
            return false;
        }
        try {
            if (!$mail->Send()) {
                return false;
            } else {
                return true;
            }
        } catch (Exception ) {
            return false;
        }
    }
}