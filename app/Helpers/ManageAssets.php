<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ManageAssets
{
    /**
     * Helper :  Update assets for Floor plan, Product group
     */
    public static function updateAssets($images,$media=null, $options)
    {
        try {
            $instance = $options["instance"];
            $model = $options["model"];
            if($media){
                foreach ($media as $key => $value) {
                    $video = $instance->videos()->updateOrCreate(["vid_key" => $key], $value);
                    if (explode("/", $value["vid_url"])[1] == "storage") {
                        $tmp_path = str_replace("/storage/", "", $value["vid_url"]);
                        $extension = pathinfo($tmp_path, PATHINFO_EXTENSION);
        
                        $sub_domain = isset($options['sub_domain']) ? $options['sub_domain'] : config('app.superadmin');
        
                        $aws_file_path = $sub_domain . '/videos/' . $model . "_" . $video->id . "_" . time() . "." . $extension;
        
                        // Storage::disk('s3')->put($aws_file_path, Storage::disk("public")->get($tmp_path), "public");
                        $disk = Storage::disk('s3');
                        $disk->put($aws_file_path, fopen(Storage::path($tmp_path), 'r+'), "public");

                        $aws_public_url = Storage::disk('s3')->url($aws_file_path);
        
                        $video->update(["vid_url" => $aws_public_url]);
        
                        Storage::disk("public")->delete($tmp_path);
                    }
    
                }
            }

            foreach ($images as $key => $value) {
                $image = $instance->images()->updateOrCreate(["pic_key" => $key], $value);

                if (explode("/", $value["pic_url"])[1] == "storage") {
                    $tmp_path = str_replace("/storage/", "", $value["pic_url"]);
                    $extension = pathinfo($tmp_path, PATHINFO_EXTENSION);

                    $sub_domain = isset($options['sub_domain']) ? $options['sub_domain'] : config('app.superadmin');

                    $aws_file_path = $sub_domain . '/images/' . $model . "_" . $image->id . "_" . time() . "." . $extension;

                    Storage::disk('s3')->put($aws_file_path, Storage::disk("public")->get($tmp_path), "public");

                    $aws_public_url = Storage::disk('s3')->url($aws_file_path);

                    $image->update(["pic_url" => $aws_public_url]);

                    Storage::disk("public")->delete($tmp_path);
                }
            }
            

            $new_image_cnt = count($images);
            $current_image_cnt = $instance->images()->count();

            if ($new_image_cnt !== $current_image_cnt) {
                $instance->images()->where("_key", ">", $new_image_cnt)->delete();
            }
        } catch (\Exception $e) {
            $error = [
                __FILE__,
                __LINE__,
                $e->getMessage()
            ];
            Log::error(json_encode($error));
            return back()->with('error', $e->getMessage());
        }
    }

    public static function updateLogo($logo, $options)
    {
        try {
            $instance = $options["instance"];

            if (explode("/", $logo)[1] == "storage") {
                $tmp_path = str_replace("/storage/", "", $logo);
                $extension = pathinfo($tmp_path, PATHINFO_EXTENSION);

                $sub_domain = isset($options['sub_domain']) ? $options['sub_domain'] : config('app.superadmin');

                $aws_file_path = $sub_domain . '/images/' . "contractor" . "_" . $instance->id . "_" . time() . "." . $extension;

                Storage::disk('s3')->put($aws_file_path, Storage::disk("public")->get($tmp_path), "public");

                $aws_public_url = Storage::disk('s3')->url($aws_file_path);

                $instance->logo = $aws_public_url;
                $instance->save();

                Storage::disk("public")->delete($tmp_path);
            }
        } catch (\Exception $e) {
            $error = [
                __FILE__,
                __LINE__,
                $e->getMessage()
            ];
            Log::error(json_encode($error));
            return back()->with('error', $e->getMessage());
        }
    }
}
