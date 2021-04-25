<?php

class Image {

    // Set a constant variable for maximum filesize of 5mb
    public static $MAX_FILE_SIZE = 5 * 1024 * 1024;

    // Set a the constant variable for the upload path
    public static $BASE_UPLOAD_PATH = "uploads/";

    /**
     * Returns a string to the final upload path of the image.
     */
    public function upload($photo): string
    {
        // Create an associative array of mimetype to file extension
        $allowedFileExtensions = [
            "image/jpeg" => "jpg",
            "image/jpg" => "jpg",
            "image/gif" => "gif",
            "image/png" => "png",
        ];

        // Pluck out the name, type, size and `tmp_name` from the $_FILES["photo"] array
        $filename = $photo["name"];
        $filetype = $photo["type"];
        $filesize = $photo["size"];
        $filetmpname = $photo["tmp_name"];

        // Check if the file extension exists in allowed file extensions array
        // and exit the process if not.
        $fileext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($fileext, array_values($allowedFileExtensions))) {
            die("Error: Please select a valid file format.");
        }

        // Verify the file size does not exceed our allowable maximum
        if ($filesize >= self::$MAX_FILE_SIZE) {
            die("Error: File size is larger than the allowed limit.");
        }

        // Verify the MIME-type of the file is in the allowed file extensions array
        if (array_key_exists($filetype, $allowedFileExtensions)) {
            // Use `uniqid`, `time`, and the known file extension to generate
            // a unique filename to upload to the folder
            $unique_value = uniqid();
            $curr_timestamp = time();
            $unique_filename = "{$curr_timestamp}_{$unique_value}.{$fileext}";
            $base_path = self::$BASE_UPLOAD_PATH;

            // Strip the EXIF data from the image file before uploading to folder
            $img = new \Imagick($filetmpname);
            $profiles = $img->getImageProfiles("icc", true);
            $img->stripImage();
            if (!empty($profiles)) {
                $img->profileImage("icc", $profiles['icc']);
            }
            $img->writeImage($filetmpname);

            // Move the uploaded file from it's temporary filepath to the upload folder
            move_uploaded_file($filetmpname, "{$base_path}{$unique_filename}");

            return $unique_filename;
        }

        return null;
    }

}
