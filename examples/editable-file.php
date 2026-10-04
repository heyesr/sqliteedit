<?php
    require('../common.php');
    
    $sqle = new SQLiteEditDownload();
    
    $sqle->header();
    $sqle->heading('An editable demo using a file-upload input');
?>

<SQLiteEdit::source>
<div>
<?php
    // Include the SQLiteEdit.php file at the top of the
    // page  before any output is sent to the browser.

    $editor = new SQLiteEdit([
        'filename' => './sqliteedit.db',
        'table'    => 'images',

        // Set the image field as being editable.
        'editable' => [
            'image' => true
        ],
        
        // Stipulate that the editable field is a filee upload type
        'editable_types' => [
            'image' => 'file'
        ],
        
        'columns_names' => [
            'id'    => 'ID',
            'Image' => 'Image'
        ],
        
        //
        // Use the columns_callback option to add an onclick
        // event listener to the image that, when the image is
        // clicked, shows a larger version of the image in a
        // modal popup (using the editor_modal.show() function).
        //
        'columns_callbacks' => [
            'image' => function ($editor, $row, $name, $value)
            {
                if ($value) {
                    return sprintf(
                        '<img src="./uploaded-images/%s"
                              onclick="editor_modal.show(\'<img id=&quot;modal-img-tag&quot; style=&quot;max-width: 600px&quot; />\', {width: \'auto\'}); document.getElementById(\'modal-img-tag\').src=\'./uploaded-images/%s\'; document.getElementById(\'editor-modaldialog-dialog\').style.textAlign = \'center\';"
                              height="32"/>',
                        $value,
                        $value
                    );
                }
            }
        ],
        
        
        // The image field is not escaped so that the
        // image is seen by the user and not the HTML.
        'columns_escape' => [
            'image' => false
        ],
        
        //
        // When a file is uploaded this code is run. The handler
        // moves the
        // upoaded file into a sub-directory of the
        // editable-file.php script. On your server you might need
        // to set this directory (or the current directory) to be
        // writeable by the webserver so that it can save the
        // images that are uploaded.
        //
        'editable_types_file_callbacks' => [
            'image' => function ($obj, $field, $file)
            {
                // Ensure the CWD is writeable
                if (!is_writeable('.')) {
                    editor_messages::error($obj->id, 'The directory containing the examples is not writeable!');
                    editor_redirect('editable-file.php');
                }

                //
                // Make the uploaded-images folder if it doesn't
                // already exist.
                //
                if (!file_exists('./uploaded-images')) {
                    mkdir('uploaded-images');
                }
            
                if ($file['error'] === UPLOAD_ERR_OK) {
                    $filename = basename($file['tmp_name']) . '.png';
    
                    // Move the file into the examples folder
                    move_uploaded_file(
                        $file['tmp_name'],
                        './uploaded-images/' . $filename
                    );
    
                    // Whatever is returned by this function gets
                    // stored in the database.
                    return $filename;
                }
            }
        ],
        'columns_widths' => [
            'id' => 75
        ],
        'paging_perpage' => 10,
        'style' =>[
            'div.editor {line-height: initial;}',
            'div.editor table {margin-left: auto; margin-right: auto; width: 675px;}',
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