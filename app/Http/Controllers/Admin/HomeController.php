<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\NotificationFirebaseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Language;
use App\Models\Portfolio;
use App\Models\PortfolioView;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use Upload_Files, NotificationFirebaseTrait;

    public function index(Request $request)
    {

        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfWeekYmd = Carbon::now()->startOfWeek()->format('Y-m-d');

        $endOfWeek = Carbon::now()->endOfWeek();
        $endOfWeekYmd = Carbon::now()->endOfWeek()->format('Y-m-d');

        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfMonthYmd = Carbon::now()->startOfMonth()->format('Y-m-d');

        $endOfMonth = Carbon::now()->endOfMonth();
        $endOfMonthYmd = Carbon::now()->endOfMonth()->format('Y-m-d');


        $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d');
        $startOfYearYmd = Carbon::now()->startOfYear();

        $endOfYear = Carbon::now()->endOfYear();
        $endOfYearYmd = Carbon::now()->endOfYear()->format('Y-m-d');

        $admins = Admin::count();
        $users =100;
        $online_users = 100;
        $ordinary_users = 100;
        $distinct_users = 100;
        $portfolios = 100;
        $shopping_campaign = 100;
        $verified_users = 100;
        $blocked_users = 100;

        $likes = 100;

        $views = 100;


        ########### ANALYSIS ###########


        $languages = 2;



        if ($request->ajax())
        {

            return response()->json([
                'users' => $users,
                'ordinary_users' => $ordinary_users,
                'distinct_users' => $distinct_users,
                'portfolios' => $portfolios,
                'shopping_campaign' => $shopping_campaign,
                'verified_users' => $verified_users,
                'verified_user_requests' => 100,
                'active_users' => 100,
                'blocked_users' => $blocked_users,
                'contacts' => 100,
                'views' => $views,
                'likes' => $likes,
                'online_users' => $online_users,

            ]);
        }
        $active_users=$verified_user_requests=$contacts=0;

        return view('Admin.home.index', compact('admins', 'languages', 'users', 'contacts',
            'blocked_users', 'verified_users', 'verified_user_requests', 'portfolios', 'shopping_campaign',
            'distinct_users', 'ordinary_users', 'likes', 'views','online_users'


        ));
    }//end fun


    public function calender(Request $request)
    {
        $arrResult = [];
        $orders = Booking::get();
        //get count of orders by days
        foreach ($orders as $row) {
            $date = date('Y-m-d', strtotime($row->created_at));
            if (isset($arrResult[$date])) {
                $arrResult[$date]["counter"] += 1;
                $arrResult[$date]["id"][] = $row->id;
            } else {
                $arrResult[$date]["counter"] = 1;
                $arrResult[$date]["id"][] = $row->id;

            }
        }
        //  dd($arrResult);
        //make format of calender
        $Events = [];
        if (count($arrResult) > 0) {
            $i = 0;
            foreach ($arrResult as $item => $value) {
                $title = $value['counter'];
                $Events[$i] = [
                    'id' => $i,
                    'title' => $title,
                    'start' => $item,
                    'ids' => $value['id'],
                ];
                $i++;
            }
        }
        //return to calender
        return $Events;
    }//end fun


    public function requests_calenders()
    {
        return view('Admin.requests.calenders.index');
    }


}//end clas
