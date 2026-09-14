<?php
    require('../common.php');
    
    $sqle = new SQLiteEditDownload();
    
    $sqle->header();
    $sqle->heading('An editable demo using a color selector');
?>

<p>
    In this demo the username column is reused as the Favourite color
    column - so thats why you'll see usernames in the color column! This
    doesn't affect the editing of the column though.
</p>

<SQLiteEdit::source>
<?php
    // Include the SQLiteEdit.php file at the top of the
    // page  before any output is sent to the browser.
    
    $editor = new SQLiteEdit([

        'filename'      => './sqliteedit.db',
        'table'         => 'accounts',

        'sql_select'    => "SELECT id, username, forename, surname FROM accounts WHERE {where} {order}",
        'columns_names' => [
            'id'       => 'ID',
            'username' => 'Favourite&nbsp;color',
            'forename' => 'Forename',
            'surname'  => 'Surname'
        ],
        'columns_widths' => [
            'id' => 50,
            '*' => 250
        ],
        'columns_escape' => [
            'username' => false
        ],
        'editable'  => [
            'username' => true
        ],
        'editable_types' =>[
            'username' => 'color'
        ],
        'style' => [
            'div.editor {line-height: initial;}'
        ]
    ]);
    
    $editor->draw();
?>
</SQLiteEdit::source>

<?php
    $sqle->source();
    $sqle->footer();
?>