<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Βήμα 1: Ορισμός Παραμέτρων Βάσης Δεδομένων και Διακομιστή';
$lang['intro_text']		=	'Πριν να μπορούμε να ελέγξουμε την βάση δεδομένων, πρέπει να ξέρουμε που βρίσκεται και πως να συνδεθούμε σε αυτήν.';

$lang['db_settings']	=	'Παραμέτροι Βάσης Δεδομένων';
$lang['db_text']		=	'Για να μπορέσει το πρόγραμμα εγκατάστασης την έκδοση του διακομιστή MySQL σας απαιτείται η εισαγωγή του hostname, του ονόματος χρήστη και του κωδικού πρόσβασης στην παρακάτω φόρμα. Αυτές οι παραμέτροι θα χρησιμοποιηθούν και κατά την εγκατάσταση της βάσης δεδομένων.';

$lang['server']			=	'Hostname';
$lang['username']		=	'Όνομα χρήστη';
$lang['password']		=	'Κωδικός πρόσβασης';
$lang['portnr']			=	'Θύρα';
$lang['server_settings']=	'Ρυθμίσεις Διακομιστή';
$lang['httpserver']		=	'Διακομιστής HTTP';
$lang['httpserver_text']=	'Το PyroCMS χρειάζεται έναν διακομιστή HTTP για να προβάλλει δυναμικό περιεχόμενο όταν κάποιος επισκέπτεται τον ιστότοπό σας. Εφόσον μπορείτε να βλέπετε αυτήν την σελίδα είναι προφανές ότι έχετε ένα τέτοιο διακομιστή. Το PyroCMS γνωρίζοντας τον ακριβή τύπο του διακομιστή HTTP μπορεί να ρυθμίσει τον εαυτό του καλύτερα. Αν δεν καταλαβάνετε τι σημαίνουν όλα αυτά, απλώς αγνοήστε τα και συνεχίστε την εγκατάσταση.';
$lang['rewrite_fail']	=	'Έχετε επιλέξει "(Apache with mod_rewrite)" αλλά δεν ήταν δυνατό να διευκρινιστεί αν το mod_rewrite είναι ενεργοποιημένο στον διακομιστή σας. Ρωτήστε τον host σας αν το mod_rewrite είναι ενεργοποιημένο ή απλώς συνεχίστε την εγκατάσταση με δική σας ευθύνη.';
$lang['mod_rewrite']	=	'Έχετε επιλέξει "(Apache with mod_rewrite)" αλλά ο διακομιστής σας δεν έχει το mod_rewrite ενεργοποιημένο. Ζητήστε από τον host σας να το ενεργοποιήσει ή εγκαταστήστε το PyroCMS χρησιμοποιώντας την επιλογή "Apache (without mod_rewrite)".';
$lang['step2']			=	'Βήμα 2';

// messages
$lang['db_success']		=	'Οι παραμέτροι της βάσης δεδομένων ελέγχθηκαν και δουλεύουν μια χαρά.';
$lang['db_failure']		=	'Πρόβλημα κατά την σύνδεση με την βάση δεδομένων: ';

/* End of file step_1_lang.php */