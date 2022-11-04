<?php

namespace App\Services\PostService;

use App\Models\Post;
use App\Traits\Upload;
use Illuminate\Support\Facades\Cache;

class Action
{
    use Upload;

    protected $post;
    public $folder;
    public $insertSection;
    public $updateSection;

    /**
     * @param model $post
     * @return folder name folder
     * @return insertSection upload file, if condition true file uploaded
     * @return updateSection upload file, if condition false old file delete then upload new file
     */

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->folder = 'posts';
        $this->insertSection = true;
        $this->updateSection = false;
    }

    /**
     * @return Post data post with cache
     * 60 * 60 * 5 = 5 Hour
     */

    public function indexData()
    {
        return Cache::remember('post-cache', 60 * 60 * 5, function () {
            return $this->post->paginate(10);
        });
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\UpdatePostRequest  $request
     */
    public function storeData($request)
    {
        $filename = $this->createFile($this->insertSection, $this->folder, $request->acticle_image);
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'acticle_image' => $filename,
            'acticle_creator' => $request->acticle_creator,
        ];

        return $this->post->create($data);
    }

    /**
     * Update a newly created resource in storage.
     * @param  \Illuminate\Http\UpdatePostRequest  $request
     * @param  Post  $post
     */
    public function updateData($request, $post)
    {
        $filename = $post->acticle_image;

        if ($request->hasFile('acticle_image')) {
            $filename = $this->createFile($this->updateSection, $this->folder, $request->acticle_image, $post->acticle_image);
        }

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'acticle_image' => $filename,
            'acticle_creator' => $request->acticle_creator,
        ];

        return $post->update($data);
    }

    /**
     * Remove the specified resource from storage with file.
     * @param  \Illuminate\Http\UpdatePostRequest  $request
     * @param  Post  $post
     */
    public function deleteData($post)
    {
        if (!empty($post->acticle_image)) {
            $this->deleteFile($this->updateSection, $this->folder, $post->acticle_image);
        }

        return $post->delete();
    }
}
