<?php

namespace App\Http\Controllers;

use App\Customer;
use App\FinishedProduct;
use App\FPCategory;
use App\Http\Controllers\Controller;
use App\Imports\CustomerImport;
use App\Imports\ProductImport;
use App\Imports\RawMaterialImport;
use App\Imports\SupplierImport;
use App\ProductionStage;
use App\RawMaterial;
use App\RawMaterialCategory;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DataImportController extends Controller
{
    public function index()
    {
        $type = [
            'raw_material' => 'Material',
            'product' => 'Product',
            'customer' => 'Customer',
            'supplier' => 'Supplier',
        ];
        $title = 'Data Import';
        return view('pages.data-import.index', compact('title', 'type'));
    }
    public function import(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'import_file' => 'required|mimes:xls,xlsx',
        ]);
        $errors = [];
        try {
            $rows = Excel::toCollection(null, $request->file('import_file'))[0];
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to read Excel file: ' . $e->getMessage())->withInput();
        }
        $rows = $rows->slice(3)->values();
        foreach ($rows as $index => $row) {
            try {
                $rowData = $this->mapRowData($request->type, $row);
                $rules = $this->getValidationRules($request->type);
                $validator = Validator::make($rowData, $rules);
                if ($validator->fails()) {
                    $errors[$index + 3] = [
                        'type' => 'Validation Error',
                        'messages' => $validator->errors()->all()
                    ];
                    continue;
                }
                $this->storeRow($request->type, $rowData);
            } catch (\Exception $e) {
                $errors[$index + 3] = [
                    'type' => 'System Error',
                    'messages' => [$e->getMessage()]
                ];
            }
        }
        if (!empty($errors)) {
            return back()->with('error', 'Import completed with issues.')->with('import_errors', $errors)->withInput();
        }
        return back()->with('success', 'Data imported successfully.');
    }
    public function sample()
    {
        return response()->download(storage_path('sample.zip'));
    }
    protected function mapRowData($type, $row)
    {
        switch ($type) {
            case 'customer':
                return [
                    'vendor_code' => $row[0],
                    'name' => $row[1],
                    'phone' => $row[2],
                    'email' => $row[3],
                    'customer_type' => $row[4],
                    'gst_no' => $row[5],
                    'pan_no' => $row[6],
                    'hsn_sac_no' => $row[7],
                    'ecc_no' => $row[8],
                    'area' => $row[9],
                    'address' => $row[10],
                    'note' => $row[11],
                ];
            case 'supplier':
                return [
                    'name' => $row[0],
                    'contact_person' => $row[1],
                    'phone' => $row[2],
                    'email' => $row[3],
                    'gst_no' => $row[4],
                    'ecc_no' => $row[5],
                    'area' => $row[6],
                    'address' => $row[7],
                    'note' => $row[8],
                ];
            case 'product':
                return [
                    'code' => $row[0],
                    'name' => $row[1],
                    'product_category' => $row[2],
                    'hsn_sac_no' => $row[3],
                    'danish_sin_no' => $row[4],
                    'part_name' => $row[5],
                    'part_no' => $row[6],
                    'description' => $row[7],
                    'remarks' => $row[8],
                    'material_category' => $row[9],
                    'raw_materials' => $row[10],
                    'production_stage' => $row[11],
                ];
            case 'raw_material':
                return [
                    'code' => $row[0],
                    'name' => $row[1],
                    'category' => $row[2],
                    'insert_type' => $row[3],
                    'diameter' => $row[4],
                    'heat_no' => $row[5],
                    'description' => $row[6],
                    'remarks' => $row[7],
                ];
            default:
                return [];
        }
    }
    protected function getValidationRules($type)
    {
        switch ($type) {
            case 'customer':
                return [
                    'name' => 'required|max:50|regex:/^[\pL\s]+$/u',
                    'customer_type' => 'required',
                    'phone' => [
                        'required',
                        'digits:10',
                        'regex:/^[1-9][0-9]{9}$/',
                        Rule::unique('tbl_customers', 'phone')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'email' => [
                        'nullable',
                        'email:filter',
                        Rule::unique('tbl_customers', 'email')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'address' => 'max:250',
                    'hsn_sac_no' => [
                        'nullable',
                        'max:20'
                    ],
                    'gst_no' => [
                        'nullable',
                        'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][A-Z0-9]{3}$/',
                        Rule::unique('tbl_customers', 'gst_no')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'pan_no' => [
                        'nullable',
                        'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                        Rule::unique('tbl_customers', 'pan_no')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'ecc_no' => [
                        'nullable',
                        'regex:/^\d{1,9}$/',
                        Rule::unique('tbl_customers', 'ecc_no')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'area' => 'max:50',
                    'note' => 'max:250',
                    'vendor_code' => [
                        'required',
                        'max:20',
                        Rule::unique('tbl_customers', 'vendor_code')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                ];
            case 'supplier':
                return [
                    'name' => 'required|max:50|regex:/^[\pL\s]+$/u',
                    'contact_person' => 'nullable|max:50|regex:/^[\pL\s]+$/u',
                    'phone' => [
                        'required',
                        'digits:10',
                        'regex:/^[1-9][0-9]{9}$/',
                        Rule::unique('tbl_suppliers', 'phone')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'email' => [
                        'nullable',
                        'email:filter',
                        Rule::unique('tbl_suppliers', 'email')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'gst_no' => [
                        'nullable',
                        'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][A-Z0-9]{3}$/',
                        Rule::unique('tbl_suppliers', 'gst_no')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'ecc_no' => [
                        'nullable',
                        'regex:/^\d{1,9}$/',
                        Rule::unique('tbl_suppliers', 'ecc_no')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'address' => 'max:250',
                    'area' => 'max:50',
                    'note' => 'max:250'
                ];
            case 'product':
                return [
                    'name' => [
                        'required',
                        'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                        'max:150',
                        Rule::unique('tbl_finish_products', 'name')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'code' => [
                        'required',
                        'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                        'max:50',
                        Rule::unique('tbl_finish_products', 'code')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'hsn_sac_no' => [
                        'required',
                        'max:20',
                        Rule::unique('tbl_finish_products', 'hsn_sac_no')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'part_name' => 'nullable|max:50',
                    'part_no' => 'nullable|max:20',
                    'product_category' => 'required',
                    'material_category' => 'required',
                    'raw_materials' => 'required',
                    'danish_sin_no' => 'nullable|max:20',
                    'description' => 'required|max:250',
                    'remarks' => 'nullable|max:100',
                ];
            case 'raw_material':
                return [
                    'name' => [
                        'required',
                        'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                        'max:150',
                        Rule::unique('tbl_rawmaterials', 'name')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'category' => 'required',
                    'insert_type' => 'required_if:category,Insert',
                    'code' => [
                        'required',
                        'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\/&\-\s]+$/',
                        'max:20',
                        Rule::unique('tbl_rawmaterials', 'code')->where(function ($query) {
                            return $query->where('del_status', 'Live');
                        }),
                    ],
                    'description' => 'required|max:250',
                    'remarks' => 'max:100',
                    'heat_no' => 'max:20',
                ];
            default:
                return [];
        }
    }
    protected function storeRow($type, $data)
    {
        switch ($type) {
            case 'customer':
                $customer_id = 'CUS-' . str_pad(Customer::count() + 1, 6, '0', STR_PAD_LEFT);
                Customer::create([
                    'customer_id' => $customer_id,
                    'vendor_code' => $data['vendor_code'],
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'customer_type' => $data['customer_type'],
                    'gst_no' => $data['gst_no'],
                    'pan_no' => $data['pan_no'],
                    'hsn_sac_no' => $data['hsn_sac_no'],
                    'ecc_no' => $data['ecc_no'],
                    'area' => $data['area'],
                    'address' => $data['address'],
                    'note' => $data['note'],
                ]);
                break;

            case 'supplier':
                $supplier_id = "SUP-" . str_pad(Supplier::count() + 1, 6, '0', STR_PAD_LEFT);
                Supplier::create([
                    'supplier_id' => $supplier_id,
                    'name' => $data['name'],
                    'contact_person' => $data['contact_person'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'gst_no' => $data['gst_no'],
                    'ecc_no' => $data['ecc_no'],
                    'area' => $data['area'],
                    'address' => $data['address'],
                    'note' => $data['note'],
                ]);
                break;

            case 'product':
                $category_id = FPCategory::where('name', $data['product_category'])->first();
                if ($category_id) {
                    $pro_category_id = $category_id->id;
                } else {
                    $pro_category_id = FPCategory::create(['name' => $data['product_category']]);
                }
                $mat_category_id = RawMaterialCategory::where('name', $data['material_category'])->first();
                if ($mat_category_id) {
                    $mat_category_id = $mat_category_id->id;
                } else {
                    $mat_category_id = RawMaterialCategory::create(['name' => $data['material_category']]);
                }
                $raw_materials = explode(',', $data['raw_materials']);
                $raw_material_ids = [];
                // dd($raw_materials);
                foreach ($raw_materials as $raw_material) {
                    // preg_match('/([A-Za-z0-9-]+)\((\d+)\)/', $raw_material, $matches);
                    $raw_material_id = RawMaterial::where('code', $raw_material)->first();
                    if ($raw_material_id) {
                        $raw_material_ids[] = ['raw_material_id' => $raw_material_id->id];
                    } else {
                        return redirect()->back()->with('error', 'Raw material not found: ' . $raw_material);
                    }
                }
                $production_stage_ids = [];

                preg_match_all('/([A-Za-z0-9\s]+)\((\d+,\d+,\d+,\d+)\)/', $data['production_stage'], $matches, PREG_SET_ORDER);

                if (!$matches) {
                    throw new \Exception("Invalid production_stage format: " . $data['production_stage']);
                }

                foreach ($matches as $match) {
                    $stageName = trim($match[1]);
                    $timeParts = explode(',', $match[2]);

                    if (count($timeParts) !== 4) {
                        throw new \Exception("Invalid time value for stage '$stageName'");
                    }

                    [$month, $day, $hour, $minute] = $timeParts;

                    $production_stage = ProductionStage::firstOrCreate(['name' => $stageName]);

                    $production_stage_ids[] = [
                        'production_stage_id' => $production_stage->id,
                        'month' => $month,
                        'day' => $day,
                        'hour' => $hour,
                        'minute' => $minute,
                    ];
                }
                // dd($production_stage_ids);
                $finished_product = FinishedProduct::create([
                    'code' => $data['code'],
                    'name' => $data['name'],
                    'category' => $pro_category_id,
                    'hsn_sac_no' => $data['hsn_sac_no'],
                    'danish_sin_no' => $data['danish_sin_no'],
                    'part_name' => $data['part_name'],
                    'part_no' => $data['part_no'],
                    'description' => $data['description'],
                    'remarks' => $data['remarks'],
                    'added_by' => auth()->user()->id,
                    'company_id' => auth()->user()->company_id,
                ]);
                foreach ($raw_material_ids as $raw_material){
                    $material = RawMaterial::find($raw_material['raw_material_id']);
                    $obj = new \App\FPrmitem;
                    $obj->mat_cat_id = $mat_category_id;
                    $obj->rmaterials_id = $material->id;
                    $obj->finish_product_id = $finished_product->id;
                    $obj->company_id = auth()->user()->company_id;
                    $obj->save();
                }
                foreach ($production_stage_ids as $row => $value) {
                    $production_stage = ProductionStage::find($value['production_stage_id']);
                    $obj = new \App\FPproductionstage();
                    $obj->productionstage_id = $production_stage->id;
                    $obj->stage_month = $value['month'];
                    $obj->stage_day = $value['day'];
                    $obj->stage_hours = $value['hour'];
                    $obj->stage_minute = $value['minute'];
                    $obj->finish_product_id = $finished_product->id;
                    $obj->company_id = auth()->user()->company_id;
                    $obj->save();
                }
                break;

            case 'raw_material':
                $category = RawMaterialCategory::where('name', $data['category'])->first();
                if (!$category) {
                    $cat_name = $data['category'];
                    $category = RawMaterialCategory::create(['name' => $cat_name]);
                    $category_id = $category->id;
                } else {
                    $category_id = $category->id;
                }
                if($data['category']=='Insert') {
                    $insert_type = $data['insert_type'];
                    if($insert_type=='Consumable') {
                        $ins_type = 1;
                    } else if($insert_type=='Non Consumable') {
                        $ins_type = 2;
                    } else {
                        $ins_type = null;
                    }
                } else {
                    $ins_type = null;
                }
                RawMaterial::create([
                    'code' => $data['code'],
                    'name' => $data['name'],
                    'category' => $category_id,
                    'insert_type' => $ins_type,
                    'diameter' => $data['diameter'],
                    'heat_no' => $data['heat_no'],
                    'description' => $data['description'],
                    'remarks' => $data['remarks'],
                ]);
                break;
        }
    }
}