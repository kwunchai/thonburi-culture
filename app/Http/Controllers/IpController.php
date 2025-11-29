<?php

namespace App\Http\Controllers;

use App\Models\IntellectualProperty;
use Illuminate\Http\Request;

class IpController extends Controller
{
    public function index(Request $req)
    {
        $q = IntellectualProperty::query()->whereIn('status', ['active', 'registered']);

        if ($t = $req->string('type')->toString())    $q->where('type', $t);
        if ($s = $req->string('status')->toString())  $q->where('status', $s);
        if ($kw = $req->string('q')->toString()) {
            $q->where(function($w) use ($kw){
                $w->where('title','like',"%$kw%")
                  ->orWhere('registration_number','like',"%$kw%")
                  ->orWhere('description','like',"%$kw%");
            });
        }

        $items = $q->latest('ip_id')->paginate(12)->withQueryString();

        // ใช้ distinct เป็นรายการตัวกรอง
        $types   = IntellectualProperty::select('type')->distinct()->pluck('type');
        $statuses= IntellectualProperty::select('status')->distinct()->whereNotNull('status')->pluck('status');

        return view('ip.index', compact('items','types','statuses'));
    }

    public function show(IntellectualProperty $ip)
    {
        abort_unless(in_array($ip->status, ['active', 'registered']), 404);
        return view('ip.show', compact('ip'));
    }
}
