<?php
    //
    // This script is an example of sending images to the browser
    // that have been uploaded. It reads the image from disk and
    // sends the data to the browser after sending the relevant
    // Content-Type header (it currently only supports PNG images
    // though you could detect the type of image and change this
    // to send the correct header).
    //
    // You would probably want to organise things a little and put
    // the images in their own folder - for example:
    //
    //                 /images/uploaded-images/
    //
    // You could also store the file in the database but this is
    // probably unneccessary and not necessarily the best thing to do
    // performance-wise.
    //
    if (!@$_GET['id']) {
        die('This file should not be called directly. Instead go <a href="editable-file.php">editable-file.php</a> example.');
    }

    //
    // Create the PHP SQLite3 object. This is an object that's
    // built-in to PHP.
    //
    $db = new SQLite3('./sqliteedit.db', SQLITE3_OPEN_READONLY);

    //
    // Query the database for the entry that has the id that was
    // given on the querystring.
    //
    $result = $db->query(sprintf(
        "SELECT * FROM images WHERE id = %d",
        (int)$_GET['id']
    ));
    
    //
    // Get the row data from the result set.
    //
    $row = $result->fetchArray();

    //
    // Send the appropriate Content-Type header for a PNG image.
    // This is always sent so if you want to allow other types of
    // image (eg JPG or GIF) you'll need to handle that.
    //
    header('Content-Type: image/png');
    
    //
    // Send the image data thats stored as a file on the filesystem.
    // An alternative way of doing this, depending on your system, is
    // to store the images as the users id number or in their user
    // dir. That way you might not even need to touch the database
    // for the image.
    //
    // Alternatively, you could store the whole image inside the
    // database instead of on the filesystem.
    //
    echo file_get_contents('./' . $row['image']);
?>