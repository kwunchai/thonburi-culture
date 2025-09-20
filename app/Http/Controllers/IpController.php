<?php

namespace App\Http\Controllers;

use App\Models\IntellectualProperty;
use Illuminate\Http\Request;

class IpController extends Controller
{
    public function index(Request $req)
    {
        $q = IntellectualProperty::query()->where('is_published', true);

        if ($t = $req->string('type')->toString())    $q->where('type', $t);
        if ($s = $req->string('status')->toString())  $q->where('status', $s);
        if ($y = $req->integer('year'))               $q->where('budget_year', $y);
        if ($kw = $req->string('q')->toString()) {
            $q->where(function($w) use ($kw){
                $w->where('title','like',"%$kw%")
                  ->orWhere('application_no','like',"%$kw%")
                  ->orWhere('research_title','like',"%$kw%")
                  ->orWhere('applicant_name','like',"%$kw%");
            });
        }

        $items = $q->latest('id')->paginate(12)->withQueryString();

        // ใช้ distinct เป็นรายการตัวกรอง
        $types   = IntellectualProperty::select('type')->distinct()->pluck('type');
        $statuses= IntellectualProperty::select('status')->distinct()->whereNotNull('status')->pluck('status');
        $years   = IntellectualProperty::select('budget_year')->whereNotNull('budget_year')->distinct()->orderBy('budget_year','desc')->pluck('budget_year');

        return view('ip.index', compact('items','types','statuses','years'));
    }

    public function show(IntellectualProperty $ip)
    {
        abort_unless($ip->is_published, 404);
        return view('ip.show', compact('ip'));
    }
}
