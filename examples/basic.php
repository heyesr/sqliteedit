<?php
    require('../common.php');


    $sqle = new SQLiteEditDownload();
    
    $sqle->header();
    $sqle->heading('Basic demo using a simple editor');
?>


<SQLiteEdit::source>
<?php
    // Include the SQLiteEdit.php file at the top of the
    // page  before any output is sent to the browser.

    $editor = new SQLiteEdit([
        'filename' => 'sqliteedit.db',
        'table'    => 'accounts',
        'checkboxes_radio' => true
    ]);
    
    $editor->draw();
?>
</SQLiteEdit::source>

<?php
    $sqle->source();
    $sqle->footer();
?>