<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\LinkResource;
use App\Models\Link;

class LinksController extends Controller
{
    public function index(Link $link)
    {
       return LinkResource::collection($link->getAllCached());
    }
}
