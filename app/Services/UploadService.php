<?php

use Illuminate\Http\UploadedFile;

class UploadService
{
    public static function uploadImage(UploadedFile $image, $folder, $type = 0)
    {
        if ($image) {
            $ext = $image->clientExtension();
            if (in_array(strtolower($ext), ["jpg", "jpeg", "png", "bmp", "gif", "svg"])) {

                $dir = "uploads/${folder}/" . date('Y') . "-" . date('m') . "-" . date('d');
                $path = $image->store('public/' . $dir);
                $storage = url('/') . Storage::url($path);
                if ($type) {
                    $storage = url('/') . str_replace('/storage', '', $storage);
                }
//        $image = Image::make($image)
//          ->resize(400, null, function ($constraint) {
//            $constraint->aspectRatio();
//          });
//        $image->save();

                return ['data' => $storage, 'status' => 200, 'message' => 'Tải ảnh thành công!'];
            } else {
                return [
                    'status' => 403,
                    'message' => 'Bạn phải chọn ảnh thuộc định dạng ("jpg", "jpeg", "png", "bmp", "gif", "svg") '
                ];
            }
        }
        return ['status' => 403, 'message' => 'Không tải được ảnh!'];


    }
    public static function uploadMultiFiles(Request $request, $key = 'file', $folder = 'files')
    {
        $links = [];
        if ($request->hasFile($key)) {
            foreach ($request->file($key) as $file) {
                $filename = md5(microtime()).'.'.$file->getClientOriginalName();
                $path = $folder.'/'.date('Y')."-".date('m')."-".date('d');
                Storage::disk('public')->putFileAs($path, $file, $filename);
                $filePath = Storage::disk('public')->path($path.'/'.$filename);
                $links[] = Storage::url($path.'/'.$filename);
            }
        }
        return $links;
    }
}

