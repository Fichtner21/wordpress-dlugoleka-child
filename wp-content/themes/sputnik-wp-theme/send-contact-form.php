<?php

if(isset($_POST['first-name'])) :
    $url = "https://www.google.com/recaptcha/api/siteverify";

    $data = [
        'secret' => "6LecWjsaAAAAAK3swaMOGt9LpZ5Go45j6Qwqlm_Z",
        'response' => $_POST['token'],
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context = stream_context_create($options);

    $response = file_get_contents($url, false, $context);

    $res = json_decode($response, true);

    if($res['success'] == true) {
        $first_name = strip_tags($_POST['first-name']);

        $last_name = strip_tags($_POST['last-name']);

        $topic = strip_tags($_POST['topic']);

        $content = strip_tags($_POST['message']);

        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $user_email = strip_tags($_POST['email']);

        $message = 'Formularz kontaktowy ze strony: '. $_SERVER['HTTP_REFERER'] .'</br>';
        $message .= '</hr></br>';
        $message .= 'Imię: '. $first_name .'</br>';
        $message .= 'Nazwisko: '. $last_name .'</br>';
        $message .= 'Temat: '. $topic .'</br>';
        $message .= 'Treść: '. $content .'</br>';

        $emails_array = array(
            'p.drozniak@sputnik.pl',
            'e.fichtner@sputnik.pl',
        );

        $subject = 'Formularz kontaktowy - '. $topic;

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        foreach($emails_array as $email) :
            if(mail( $email, $subject, $message, implode("\r\n", $headers))) :
                echo 'Wiadomość została wysłana poprawnie.';

                header('Location: '. $_SERVER['HTTP_REFERER']);

	            exit;
            else :
                echo 'Wystąpił błąd. Spróbuj ponownie.';

                header('Location: '. $_SERVER['HTTP_REFERER']);

	            exit;
            endif;
        endforeach;
    }
endif;