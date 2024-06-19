<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Report;
use App\Models\Commercial;
use App\Models\User;
use App\Charts\RecentCommercials;
use App\Charts\RecentUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    /**
     * AppController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:dashboard-access');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commercialCount    = Commercial::count();
        $articleCount       = Article::count();
        $userCount          = User::count();
        $reportCount        = Report::count();
        $recentUsersChart       = new RecentUsers;
        $recentCommercialsChart = new RecentCommercials;
        $lastWeekUsers      = User::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')) )
            ->count();
        $twoWeeksAgeUsers   = User::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-14 days')) )
            ->whereDate('created_at', '<', date('Y-m-d H:i:s',strtotime('-7 days')) )
            ->count();
        $threeWeeksAgeUsers = User::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-21 days')) )
            ->whereDate('created_at', '<', date('Y-m-d H:i:s',strtotime('-14 days')) )
            ->count();
        $fourWeeksAgeUsers  = User::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-28 days')) )
            ->whereDate('created_at', '<', date('Y-m-d H:i:s',strtotime('-21 days')) )
            ->count();
        $recentUsersChart->labels(['کاربران']);
        $recentUsersChart->dataset('هفته قبل', 'bar', [$lastWeekUsers])->backgroundColor('#00c0ef');
        $recentUsersChart->dataset('دو هفته قبل', 'bar', [$twoWeeksAgeUsers])->backgroundColor('#00a65a');
        $recentUsersChart->dataset('سه هفته قبل', 'bar', [$threeWeeksAgeUsers])->backgroundColor('#f39c12');
        $recentUsersChart->dataset('چهار هفته قبل', 'bar', [$fourWeeksAgeUsers])->backgroundColor('#dd4b39');

        $lastWeekCommercials      = Commercial::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')) )
            ->count();
        $twoWeeksAgoCommercials   = Commercial::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-14 days')) )
            ->whereDate('created_at', '<', date('Y-m-d H:i:s',strtotime('-7 days')) )
            ->count();
        $threeWeeksAgoCommercials = Commercial::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-21 days')) )
            ->whereDate('created_at', '<', date('Y-m-d H:i:s',strtotime('-14 days')) )
            ->count();
        $fourWeeksAgoCommercials  = Commercial::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-28 days')) )
            ->whereDate('created_at', '<', date('Y-m-d H:i:s',strtotime('-21 days')) )
            ->count();
        $recentCommercialsChart->dataset('هفته قبل', 'bar', [$lastWeekCommercials])->backgroundColor('#00c0ef');
        $recentCommercialsChart->dataset('دو هفته قبل', 'bar', [$twoWeeksAgoCommercials])->backgroundColor('#00a65a');
        $recentCommercialsChart->dataset('سه هفته قبل', 'bar', [$threeWeeksAgoCommercials])->backgroundColor('#f39c12');
        $recentCommercialsChart->dataset('چهار هفته قبل', 'bar', [$fourWeeksAgoCommercials])->backgroundColor('#dd4b39');
        return view('admin.app.index', compact('commercialCount', 'articleCount', 'userCount', 'reportCount', 'recentUsersChart', 'recentCommercialsChart'));
    }
}
