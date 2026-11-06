<?php

namespace App\Http\Controllers\Api;

use App\Models\Bookmark;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreBookmarkRequest;
use App\Http\Requests\UpdateBookmarkRequest;
use App\Http\Resources\BookmarkResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;



class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection

    {
       $bookmarks=$request->user()
       ->bookmarks()
       ->latest()
       ->paginate(15);

       return BookmarkResource::collection($bookmarks);
    //
    }
      
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $bookmark=$request->user()
      ->bookmarks()
      ->create($request->validated())
      ->response()
      ->setStatusCode(Response::HTTP_CREATED);  //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Bookmark $bookmark):BookmarkResource
    {
        abort_if($bookmark->user_id!==$request->user()->id, Response::HTTP_FORBIDDEN);
        return new BookmarkResource($bookmark);
    }

    
    public function update(UpdateBookmarkRequest $request,Bookmark $bookmark): BookmarkResource
    {
        abort_if($bookmark->user_id!==$request->user()->id,Response::HTTP_FORBIDDEN);  
    //
         $bookmark->update($request->validted());
        return new BookmarkResource($bookmark);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Bookmark $bookmark): Response
    {
      abort_if($bookmark->user_id!==$request->user()->id,Response::HTTP_FORBIDDEN);
      $bookmark->delete();
      return response()->noContent();
    //
    }
}
