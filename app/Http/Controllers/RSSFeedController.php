<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RSSFeedController extends Controller
{
    public function index()
    {
        $response = Http::get('https://timesofindia.indiatimes.com/rssfeeds/-2128838597.cms?feedtype=json');
        $data = $response->json();

        // Assume the relevant articles are in $data['channel']['item']
        $articles = $data['channel']['item'];

        return view('rss-feed', ['articles' => $articles]);
    }
}
