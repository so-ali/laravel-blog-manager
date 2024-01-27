<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    /**
     * Display the post's list.
     */
    public function index(Request $request): Response {
        $posts = Post::query()->orderBy('ID','DESC')->paginate(5);
        return Inertia::render('Post/Index', [
            'posts' => PostResource::collection($posts)->toArray($request),
        ]);
    }

    /**
     * Edit a post item.
     */
    public function edit(Request $request,?int $id = null): Response|RedirectResponse {
        if (!is_numeric($id) && empty($id)) {
            return Inertia::render('Post/Edit',['site_url'  =>  env('APP_URL','127.0.0.1')]);
        }
        $post = Post::query()->find($id);

        if (empty($post)){
            return Redirect::route('post.index');
        }

        return Inertia::render('Post/Edit', [
            'post' => $post,
            'id' => $id,
            'site_url'  =>  env('APP_URL','127.0.0.1')
        ]);
    }

    /**
     * Save the post.
     */
    public function update(PostUpdateRequest $request,?int $id = null): RedirectResponse {
        $post = Post::query()->find($request->get('id'));
        if (is_numeric($request->get('id')) && !$post->count()){
            return Redirect::route('post.edit',['id'=>$request->get('id')]);
        }
        if (empty($request->get('id'))){
            $post = new Post();
        }
        $post->fill($request->validated());
        $post->slug = Str::slug($post->slug,'-');
        $post->user_id = Auth::id();
        $post->save();
        return Redirect::route('post.index');
    }
}
