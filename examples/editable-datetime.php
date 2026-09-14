<?php
    require('../common.php');
    
    $sqle = new SQLiteEditDownload();
    
    $sqle->header();
    $sqle->heading('An editable demo using a datetime input');
?>


<SQLiteEdit::source>
<?php
    // Include the SQLiteEdit.php file at the top of the
    // page  before any output is sent to the browser.
    
    $editor = new SQLiteEdit([
        'filename'      => './sqliteedit.db',
        'table'         => 'accounts',
        'sql_select'    => "SELECT id, username, forename, surname, created FROM accounts WHERE {where} {order}",
        'columns_names' => [
            'id'       => 'ID',
            'username' => 'Username',
            'forename' => 'Forename',
            'surname'  => 'Surname',
            'created'  => 'Created'
        ],
        'columns_widths' => [
            'id' => 50,
            '*' => 200
        ],
        'editable' => [
            'created' => true
        ],
        'editable_types' => [
            'created' => 'datetime'
        ],
        'style'  => [
            'div.editor {line-height: initial;}',
        ]
    ]);
    
    $editor->draw();
?>
</SQLiteEdit::source>

<?php
    $sqle->source();
    $sqle->footer();
?>