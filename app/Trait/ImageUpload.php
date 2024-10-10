<?php

namespace App\Trait;

trait ImageUpload{

function image_upload($file, $path, $oldImage = null) {
    // If an old image exists, delete it
    if ($oldImage && file_exists($path . '/' . $oldImage)) {
        unlink($path . '/' . $oldImage);
    }

    // Generate a unique name for the new image
    $newName = uniqid() . '.' . $file->getClientOriginalExtension();

    // Move the uploaded file to the specified directory with the new name
    $file->move($path, $newName);

    // Return the new image name
    return $newName;
}

}

?>