<?php

namespace App\Services;

use App\Repositories\ImageRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * @var ImageRepository
     */
    protected $image_repository;

    /**
     * ImageService constructor.
     *
     * @param ImageRepository $image_repository
     */
    public function __construct(
        ImageRepository $image_repository
    ) {
        $this->image_repository = $image_repository;
    }

    /**
     * Create new image and put s3
     *
     * @param array $images
     * @param integer $message_id
     * @return Image $image
     */
    public function createNewImages(array $images, int $message_id)
    {
        DB::beginTransaction();
        try {
            foreach ($images as $image) {
                $path = Storage::disk('s3')->put('/', $image);
                $data = [
                    's3_file_path' => $path,
                    'message_id' => $message_id,
                ];
                $this->image_repository->create($data);
            }
        } catch (Exception $error) {
            DB::rollback();
            Log::error($error->getMessage());
            throw new Exception($error->getMessage());
        }
        DB::commit();

        return $image;
    }

    /**
     * Create temporary url from path
     *
     * @param String $s3_file_path
     * @return String
     */
    public function createTemporaryUrl(String $s3_file_path)
    {
        return Storage::disk('s3')->temporaryUrl($s3_file_path, Carbon::now()->addDay());
    }
}
