<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->from ?? 0;
        $toDate = $request->to ?? 0;

        $transactions = Transaction::with('details', 'user')->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', Carbon::parse($toDate)->addDay())->get();
        $orders = Order::with('user')->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', Carbon::parse($toDate)->addDay())->get();
        $datas = $orders->concat($transactions)->values()->sortByDesc('created_at');

        return view('admin.report.index', compact('datas', 'fromDate', 'toDate'));
    }
}
