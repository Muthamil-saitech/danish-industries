<?php
/*
  ##############################################################################
  # iProduction - Production and Manufacture Management Software
  ##############################################################################
  # AUTHOR:		Door Soft
  ##############################################################################
  # EMAIL:		info@doorsoft.co
  ##############################################################################
  # COPYRIGHT:		RESERVED BY Door Soft
  ##############################################################################
  # WEBSITE:		https://www.doorsoft.co
  ##############################################################################
  # This is DepositController
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Account;
use App\Deposit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepositController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj = Deposit::where('del_status', "Live")->orderBy('id', 'DESC')->get();
        $title = __('index.deposit_list');

        return view('pages.deposit.index', compact('title', 'obj'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('index.add_deposit');
        $company_id = auth()->user()->company_id;
        $account = Account::where('del_status', "Live")->first();
        // $obj = Deposit::count();
        // $ref_no = str_pad($obj + 1, 6, '0', STR_PAD_LEFT);
        return view('pages.deposit.create', compact('title','account'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'reference_no' => [
                'required',
                'max:20',
                Rule::unique('tbl_deposits', 'reference_no')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'date' => 'required|date',
            'amount' => 'required|numeric',
            // 'opening_balance' => 'required|numeric',
            'type' => 'required',
            // 'account_id' => 'required',
        ],
            [
                'reference_no.required' => __('index.reference_no_required'),
                'reference_no.max' => __('index.reference_no_max'),
                'date.required' => __('index.date_required'),
                'date.date' => __('index.date_date'),
                'amount.required' => __('index.amount_required'),
                // 'opening_balance.required' => "Opening balance is required",
                // 'opening_balance.numeric' => "Opening balance must be a number",
                'amount.numeric' => __('index.amount_numeric'),
                'type.required' => 'The Deposit Or Withdraw field is required',
                // 'account_id.required' => __('index.account_required'),
            ]
        );
        $total_dep = getTotalCredit(1);
        $total_deb = getTotalDebit(1);
        $balance = $total_dep - $total_deb;
        if ($request->type == 'Withdraw' && $request->amount > $balance) {
            return back()->with('error', 'Insufficient balance.')->withInput();
        }
        $deposit = Deposit::where('del_status','Live')->where('account_id','!=','')->count();
        if($deposit==0) {
            $account = new Account();
            $account->name = 'Danish';
            $account->opening_balance = 0;
            $account->save();
        }
        $obj = new \App\Deposit;
        $obj->reference_no = escape_output($request->reference_no);
        $obj->date = date('Y-m-d',strtotime(escape_output($request->date)));
        $obj->amount = escape_output($request->amount);
        $obj->type = escape_output($request->type);
        $obj->account_id = 1;
        $obj->note = escape_output($request->note);
        $obj->user_id = auth()->user()->id;
        $obj->company_id = auth()->user()->company_id;
        $obj->save();
        return redirect('deposit')->with(saveMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $deposit = Deposit::find(encrypt_decrypt($id, 'decrypt'));
        $title = __('index.edit_deposit');
        $obj = $deposit;
        $company_id = auth()->user()->company_id;
        $account = Account::where('del_status', "Live")->first();
        return view('pages.deposit.edit', compact('title', 'obj', 'account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposit $deposit)
    {
        request()->validate([
            'reference_no' => [
                'required',
                'max:20',
                Rule::unique('tbl_deposits', 'reference_no')->ignore($deposit->id,'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'type' => 'required',
            // 'account_id' => 'required',
        ],
            [
                'reference_no.required' => __('index.reference_no_required'),
                'reference_no.max' => __('index.reference_no_max'),
                'date.required' => __('index.date_required'),
                'date.date' => __('index.date_date'),
                'amount.required' => __('index.amount_required'),
                'amount.numeric' => __('index.amount_numeric'),
                'type.required' => __('index.type_required'),
                // 'account_id.required' => __('index.account_required'),
            ]
        );
        $total_dep = getTotalCredit(1);
        $total_deb = getTotalDebit(1);
        $balance = $total_dep - $total_deb;
        if ($request->type == 'Withdraw' && $request->amount > $balance) {
            return back()->with('error', 'Insufficient balance.')->withInput();
        }
        $deposit->reference_no = escape_output($request->reference_no);
        $deposit->date = date('Y-m-d',strtotime(escape_output($request->date)));
        $deposit->amount = escape_output($request->amount);
        $deposit->type = escape_output($request->type);
        $deposit->account_id = 1;
        $deposit->note = escape_output($request->note);
        $deposit->save();

        return redirect('deposit')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposit $deposit)
    {
        $deposit->del_status = "Deleted";
        $deposit->save();
        return redirect('deposit')->with(deleteMessage());
    }

}
