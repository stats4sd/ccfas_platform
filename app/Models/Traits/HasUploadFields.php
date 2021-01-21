<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Methods for storing uploaded files (used in CRUD).
|--------------------------------------------------------------------------
*/
trait HasUploadFields
{
    /**
     * Handle file upload and DB storage for a file:
     * - on CREATE
     *     - stores the file at the destination path
     *     - generates a name
     *     - stores the full path in the DB;
     * - on UPDATE
     *     - if the value is null, deletes the file and sets null in the DB
     *     - if the value is different, stores the different file and updates DB value.
     *
     * @param string $value            Value for that column sent from the input.
     * @param string $attribute_name   Model attribute name (and column in the db).
     * @param string $disk             Filesystem disk used to store files.
    * @param string $destination_path Path in disk where to store the files.
     */
    public function uploadFileToDiskFromRepeatable($value, $attribute_name, $disk, $destination_path)
    {
        $destination_path .= "/".time();

        $request = Request::instance();
   
        // if a new file is uploaded, delete the file from the disk
        if ($request->hasFile($attribute_name) &&
            $this->{$attribute_name} &&
            $this->{$attribute_name} != null) {
            Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        // if the file input is empty, delete the file from the disk
        if (is_null($value) && $this->{$attribute_name} != null) {
            Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }
        // if a new file is uploaded, store it on disk and its filename in the database
        // use the given value to select which of the file uploads to take...
        if ($request->hasFile($value) && $request->file($value)->isValid()) {
            // 1. Generate a new file name
            $file = $request->file($value);
            //$new_file_name = md5($file->getClientOriginalName().time()).'.'.$file->getClientOriginalExtension();
            $new_file_name = $file->getClientOriginalName();

            // 2. Move the new file to the correct path
            $file_path = $file->storeAs($destination_path, $new_file_name, $disk);

            // 3. Save the complete path to the database
            $this->attributes[$attribute_name] = $file_path;
        }
    }

    /**
     * Handle multiple file upload and DB storage:
     * - if files are sent
     *     - stores the files at the destination path
     *     - generates random names
     *     - stores the full path in the DB, as JSON array;
     * - if a hidden input is sent to clear one or more files
     *     - deletes the file
     *     - removes that file from the DB.
     *
     * @param string $value            Value for that column sent from the input.
     * @param string $attribute_name   Model attribute name (and column in the db).
     * @param string $disk             Filesystem disk used to store files.
     * @param string $destination_path Path in disk where to store the files.
     */
    public function uploadMultipleFilesToDiskFromRepeatable($value, $attribute_name, $disk, $destination_path)
    {
       
        $destination_path .= "/".time();

        $request = Request::instance();
        if (! is_array($this->{$attribute_name})) {
            $attribute_value = json_decode($this->{$attribute_name}, true) ?? [];
        } else {
            $attribute_value = $this->{$attribute_name};
        }
        $files_to_clear = $request->get('clear_'.$value);

        // if a file has been marked for removal,
        // delete it from the disk and from the db
        if ($files_to_clear) {
            foreach ($files_to_clear as $key => $filename) {
                Storage::disk($disk)->delete($filename);
                $attribute_value = Arr::where($attribute_value, function ($value, $key) use ($filename) {
                    return $value != $filename;
                });
            }
        }

        // if a new file is uploaded, store it on disk and its filename in the database
        // use the $value as the index to determine which of the file uploads to get
        if ($request->hasFile($value)) {
            foreach ($request->file($value) as $file) {
                if ($file->isValid()) {

                    // 1. Move the new file to the correct path with the original name
                    $file_path = $file->storeAs($destination_path, $file->getClientOriginalName(), $disk);

                    // 2. Add the public path to the database
                    
                    $attribute_value[] = $file_path;
                }
            }
        }

        $this->attributes[$attribute_name] = json_encode($attribute_value);
    }

    public function uploadFileToDiskWithOriginalName($value, $attribute_name, $disk, $destination_path)
    {
        $destination_path .= "/".time();

        $request = Request::instance();

        // if a new file is uploaded, delete the file from the disk
        if ($request->hasFile($attribute_name) &&
            $this->{$attribute_name} &&
            $this->{$attribute_name} != null) {
            Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        // if the file input is empty, delete the file from the disk
        if (is_null($value) && $this->{$attribute_name} != null) {
            Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }
        // if a new file is uploaded, store it on disk and its filename in the database
        if ($request->hasFile($attribute_name) && $request->file($attribute_name)->isValid()) {
            // 1. Generate a new file name
            $file = $request->file($attribute_name);
            //$new_file_name = md5($file->getClientOriginalName().time()).'.'.$file->getClientOriginalExtension();
            $new_file_name = $file->getClientOriginalName();

            // 2. Move the new file to the correct path
            $file_path = $file->storeAs($destination_path, $new_file_name, $disk);

            // 3. Save the complete path to the database
            $this->attributes[$attribute_name] = $file_path;
        }
    }

    public function uploadMultipleFilesToDiskWithOriginalName($value, $attribute_name, $disk, $destination_path)
    {
        $destination_path .= "/".time();


        $request = Request::instance();
        if (! is_array($this->{$attribute_name})) {
            $attribute_value = json_decode($this->{$attribute_name}, true) ?? [];
        } else {
            $attribute_value = $this->{$attribute_name};
        }
        $files_to_clear = $request->get('clear_'.$attribute_name);

        // if a file has been marked for removal,
        // delete it from the disk and from the db
        if ($files_to_clear) {
            foreach ($files_to_clear as $key => $filename) {
                Storage::disk($disk)->delete($filename);
                $attribute_value = Arr::where($attribute_value, function ($value, $key) use ($filename) {
                    return $value != $filename;
                });
            }
        }

        // if a new file is uploaded, store it on disk and its filename in the database
        if ($request->hasFile($attribute_name)) {
            foreach ($request->file($attribute_name) as $file) {
                if ($file->isValid()) {

                    // 1. Move the new file to the correct path with the original name
                    $file_path = $file->storeAs($destination_path, $file->getClientOriginalName(), $disk);

                    // 2. Add the public path to the database
                    $attribute_value[] = $file_path;
                }
            }
        }

        $this->attributes[$attribute_name] = json_encode($attribute_value);
    }
}
