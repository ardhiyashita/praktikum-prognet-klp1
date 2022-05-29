<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaction;

class ReportController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $allTransactions = Transaction::where('status', 'barang telah sampai di tujuan')->get();
        $allSales = Transaction::where('status', 'barang telah sampai di tujuan')->count();
        $monthlySales = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', $now->month)->count();
        $annualSales = Transaction::where('status', 'barang telah sampai di tujuan')->whereYear('created_at', $now->year)->count();
        $monthlyTransactions = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', $now->month)->get();
        $annualTranscations = Transaction::where('status', 'barang telah sampai di tujuan')->whereYear('created_at', $now->year)->get();
        
        $incomeTotal = 0;
        $incomeMonthly = 0;
        $incomeAnnual = 0;

        foreach ($allTransactions as $transaction) {
            $incomeTotal+=$transaction->total;
        }

        
        foreach ($monthlyTransactions as $monthly) {
            $incomeMonthly+=$monthly->total;
        }

        foreach ($annualTranscations as $annual) {
            $incomeAnnual+=$annual->total;
        }

        $january = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '01')->count();
        $february = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '02')->count();
        $march = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '03')->count();
        $april = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '04')->count();
        $may = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '05')->count();
        $june = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '06')->count();
        $july = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '07')->count();
        $august = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '08')->count();
        $september = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '09')->count();
        $october = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '10')->count();
        $november = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '11')->count();
        $december = Transaction::where('status', 'barang telah sampai di tujuan')->whereMonth('created_at', '12')->count();

        return view('admin.laporan', compact('now', 'allSales', 'monthlySales', 'annualSales', 'incomeTotal', 'incomeMonthly', 'incomeAnnual', 'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'));
    }
}
