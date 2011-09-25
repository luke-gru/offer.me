<?php
ob_start();
session_start();
require_once(realpath('../config/app_tie.php'));

// display either all notes (shortFormat) or a specific note (longFormat)
//
if (!isset($_SESSION['user']) || $_GET['to'] != $_SESSION['user']) {
    header("Location:index.php");
} else {
    $noteID = $_GET['id'];
    // user is legit, they can see their own notes
    $username = $_SESSION['user'];
    $user = UserRetriever::build($username);

    $notes = Note::findForUser($user);

    // mark as read all new notes
    print '<h2>Note</h2>';
    foreach($notes as $note) {
        if ($note->id == $noteID) {
            $display = new NoteDisplayer();
            $display->longFormat($note);
            print $display;
        }
    }

}
