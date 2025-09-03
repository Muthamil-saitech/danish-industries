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
  # This is TaxController
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Tax;
use App\TaxItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaxController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function taxes1()
    {

        $tax_items = TaxItems::where('del_status', "Live")->get();
        $taxes = Tax::all();
        return view('pages.taxes', compact('tax_items', 'taxes'));
    }
    public function taxes()
    {
        $taxes = Tax::leftJoin('tbl_tax_items', 'tbl_tax_items.id', '=', 'tbl_taxes.tax_id')
        ->select('tbl_tax_items.*', 'tbl_taxes.tax_id', 'tbl_taxes.tax', 'tbl_taxes.tax_rate')
        ->orderBy('tbl_tax_items.id','DESC')
        ->get();
        return view('pages.taxes', compact('taxes'));
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function tax_update0(Request $request)
    {
        $taxes = $request->get('taxes');
        $tax_rate = $request->get('tax_rate');
        Tax::truncate();
        foreach ($taxes as $row => $value) {
            $obj = new \App\Tax;
            $obj->tax = $value;
            $obj->tax_rate = $tax_rate[$row];
            if (isset($_POST['p_tax_id'][$row]) && $_POST['p_tax_id'][$row]) {
                $obj->id = escape_output($_POST['p_tax_id'][$row]);
            }
            $obj->save();
        }
        return redirect()->back()->with(updateMessage());
    }

    public function tax_update1(Request $request)
    {
        $taxItems = new \App\TaxItems;
        $taxItems->tax_registration_no = $request->tax_registration_no;
        $taxItems->tax_type = $request->tax_type;

        $taxItems->added_by = auth()->user()->id;
        $taxItems->save();

        Tax::where('tax_id', $taxItems->id)->update(['del_status' => "Deleted"]);

        $p_tax_id = $request->get('p_tax_id');
        foreach ($p_tax_id as $row => $value) {
            $obj = new \App\Tax;
            $obj->tax = $value;
            $obj->tax_rate = escape_output($_POST['tax_rate'][$row]);
            $obj->tax_id = $taxItems->id;
            $obj->save();
        }
        return redirect()->back()->with(updateMessage());
    }
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function tax_update(Request $request)
    {
        request()->validate([
            'collect_tax' => 'required|max:50',
            'tax_type' => [
                'required',
                Rule::exists('tbl_tax_items', 'tax_type')->where(function ($query) use ($request) {
                    return $query->where('id', $request->tax_id);
                }),
            ],
            'tax_value' => 'required|integer',
            // 'tax_registration_number' => 'required|max:50',
            ],
            [
                'collect_tax.required' => __('index.collect_tax_required'),
                'tax_type.required' => __('index.tax_type_required'),
                'tax_value.required' => __('index.tax_value_required'),
                // 'tax_registration_number.required' => __('index.tax_registration_number_required'),
            ]
        );
        $taxInfo = \App\TaxItems::find($request->tax_id);
        if (!$taxInfo) {
            $taxInfo = new \App\TaxItems;
        }
        $taxInfo->collect_tax = $request->collect_tax;
        $taxInfo->tax_type = $request->tax_type;
        $taxInfo->tax_value = $request->tax_value;
        $taxInfo->save();
        $taxValue = $request->tax_value;
        $cgst = $taxValue / 2;
        $sgst = $taxValue / 2;
        $igst = $cgst + $sgst;
        $taxTypes = [
            'CGST' => $cgst,
            'SGST' => $sgst,
            'IGST' => $igst,
        ];
        foreach ($taxTypes as $taxName => $rate) {
            \App\Tax::updateOrCreate(
                ['tax_id' => $taxInfo->id, 'tax' => $taxName],
                ['tax_rate' => $rate]
            );
        }
        return redirect()->back()->with(updateMessage());
    }
}
