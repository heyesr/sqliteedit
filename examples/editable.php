<?php
    require('../common.php');
    
    $sqle = new SQLiteEditDownload();
    
    $sqle->header();
    $sqle->heading('An editable demo');
?>

<SQLiteEdit::source>
<div>
<?php
    // Include the SQLiteEdit.php file at the top of the
    // page  before any output is sent to the browser.

    $editor = new SQLiteEdit([
        'filename'      => './sqliteedit.db',
        'table'         => 'accounts',
        'sql_select'    => 'SELECT id,
                                   username,
                                   forename,
                                   surname,
                                   created
                              FROM accounts
                             WHERE {where}
                             {order}',
        'editable'      => [
            'username' => true,
            'forename' => true,
            'surname'  => true,
            'created'  => true
        ],
        'editable_types' => [
            'username' => 'text'
        ],
        'columns_names' => [
            'id'       => 'ID',
            'username' => 'Username',
            'forename' => 'Forename',
            'surname'  => 'Surname',
            'created'  => 'Created'
        ],
        'columns_widths' => [
            'id' => 75,
            '*' => 150
        ],
        'paging_perpage' => 10,
        'style' =>[
            'div.editor {line-height: initial;}',
            'div.editor table {margin-left: auto; margin-right: auto; width: 675px;}',
            'div.editor table tr td[data-column-name=created] div {color:gray; text-align: center; font-style: italic;}',
            'div.editor :where(button, input) {font-size: 16pt;}',
            'div.editor input[type=checkbox]{cursor: pointer;transform:scale(1.5) !important;}'
        ]
    ]);
    
    $editor->draw();
?>
</div>
</SQLiteEdit::source>

<?php
    $sqle->source();
    $sqle->footer();
?>