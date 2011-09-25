<?php
require_once(realpath('../../config/app_tie.php'));
ob_start();
session_start();
?>
<head>
<style type="text/css">
#about {
margin-top:-1em;
}
.success {
color:green;
}
</style>
</head>
<?php

if (isset($_GET['user'])) {
    $url_user = $_GET['user'];

    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];


        if ($url_user !== $user) {
            // all logged in users can see this
            ?>
        <?php
        } else {
            // only current user can see this
            //
            //include(realpath('../templates/current_user_header.html'));
            if (!isset($_SESSION['root'])) {
                $_SESSION['root'] = substr($_SERVER['PHP_SELF'], 0, -17);
            }

        }
        ?>
<?php
    }
    //everyone can see this
    include('templates/logged_in_header.php');

    User::retrieveOffers($user);
    $display = new UserDisplayer();
    $display->longFormat($user);
    print $display;

    if ($_SESSION['user'] == $_GET['user']) {
        $notes = Note::findForUser($user);

        // mark as read all new notes
        $newNotes = 0;
        foreach($notes as $note) {
            if ($note->received == 0) {
                if ($newNotes == 0) {
                    print <<<HTML
                <h3>New Notes</h3>
HTML;
                    $newNotes += 1;
                }

                $display = new NoteDisplayer();
                $display->shortFormat($note);
                print $display;

                $note->received = 1;
                $note->update();
            }
        }

        $newNotes = 0;
        foreach($notes as $note) {
            if ($note->received == 1) {
                if ($newNotes == 0) {
                    print <<<HTML
                <h3>Notes</h3>
HTML;
                    $newNotes += 1;
                }

                $display = new NoteDisplayer();
                $display->shortFormat($note);
                print $display;

                $note->received = 1;
                $note->update();
            }
        }
    }

} else {
    // no query string...
    header('Location: ../index.php');

}

?>

