<?php
    require('../common.php');
    
    $sqle = new SQLiteEditDownload();
    
    $sqle->header();
    $sqle->heading('Search limited to certain columns');
?>

<p>
    In this case, limited to username, forename and surname.
</p>

<SQLiteEdit::source>
<?php
    // Include the SQLiteEdit.php file at the top of the
    // page  before any output is sent to the browser.

    $editor1 = new SQLiteEdit([
        'filename'       => './sqliteedit.db',
        'table'          => 'accounts',
        'search_columns' => ['username','forename','surname'],
        'sql_select'     => 'SELECT id,
                                    username,
                                    forename,
                                    surname
                               FROM {table}
                              WHERE {where}
                                    {order}',
        'columns_names'  => [
            'id' => 'ID',
            'username' => 'Username',
            'forename' => 'Forename',
            'surname'  => 'Surname'
        ],
        'columns_callbacks' => [
            'username' => function ($obj, $columns, $column, $value)
            {
                return rtrim(substr($value ? $value : '', 0, 20)) . (strlen($value ? $value : '') > 15 ? '...' : '');
            }
        ],
        'style' => [
            'div.editor {line-height: initial;}',
            'div.editor table{width: 75%; margin-left: auto; margin-right: auto;}',
        ]
    ]);
    
    $editor1->draw();
?>

</SQLiteEdit::source>

<?php
    $sqle->source();
    $sqle->footer();
?>