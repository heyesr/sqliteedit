<?php
    require('../common.php');
    
    $sqle = new SQLiteEditDownload();
    
    $sqle->header();
    $sqle->heading('An editable demo using a file-upload input (database storage)');
?>

<p>
    This demo stores images in the images_database table - instead
    of just the image filename (and the image itself is stored on
    the disk).
</p>

<p>
    When the image is clicked the <i>editor_modal.show()</i>
    function is used to show a modal that contains the full
    size image. If you full size images are quite large though
    you may need to set width and/or height dimensions on the
    tag.
</p>

<SQLiteEdit::source>
<div>
<?php
    // Include the SQLiteEdit.php file at the top of the
    // page  before any output is sent to the browser.

    $editor = new SQLiteEdit([
        'filename' => './sqliteedit.db',
        'table'    => 'images_database',

        // Set the image field as being editable.
        'editable' => [
            'image' => true
        ],
        
        // Stipulate that the editable field is a file upload type
        'editable_types' => [
            'image' => 'file'
        ],
        
        'columns_names' => [
            'id'    => 'ID',
            'image' => 'Image'
        ],
        
        //
        // Use the columns_callback option to change the raw image base64
        // encoded data into a data: URL that can be used as the src
        // of an image tag.
        //
        'columns_callbacks' => [
            'image' => function ($editor, $row, $name, $value)
            {
                if ($value) {
                    
                    return sprintf(
                        '<img src="data:image/png;base64,%s"
                              onclick="editor_modal.show(\'<img id=&quot;modal-img-tag&quot; style=&quot;max-width: 600px&quot; />\', {width: \'auto\'}); document.getElementById(\'modal-img-tag\').src=this.src; document.getElementById(\'editor-modaldialog-dialog\').style.textAlign = \'center\';"
                              height="32"
                         />',

                        $value
                    );
                }
            }
        ],
        
        
        // No tooltip for the image field.
        'columns_tooltips' => [
            'image' => false
        ],
        
        
        // The image field is not escaped so that the
        // image is seen by the user and not the HTML.
        'columns_escape' => [
            'image' => false
        ],
        
        //
        // When a file is uploaded this code is run. The function
        // reads in the uploaded file, base64 encodes it and
        // returns it, whereupon it's stored as a base64 encoded
        // string in the database by SQLite Edit.
        //
        'editable_types_file_callbacks' => [
            'image' => function ($obj, $field, $file)
            {            
                if ($file['error'] === UPLOAD_ERR_OK) {

                    // Read in the data from disk and base64 encode
                    // it.
                    $data = file_get_contents($file['tmp_name']);
                    $data = base64_encode($data);
    
                    // Whatever is returned by this function gets
                    // stored in the database.
                    return $data;
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