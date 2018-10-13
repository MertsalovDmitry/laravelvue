<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeTreeResource;
use Carbon\Carbon;
use DateTime;

use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function home(){
        return view('employees.tree');
    }

    public function list(){
        // return EmployeeResource::collection(Employee::All());
        return view('employees.list');
    }

    public function tree(Request $request){
        $id = null;
        if ($request->filled('id')) {
            $id = $request->id;
            $employee = Employee::find($id);
            if ($employee){
                //$employees = $employee->descendants()->get();
                $employees = $employee->immediateDescendants()->get();
                return EmployeeResource::collection($employees);
            }
        } else 
        {
            $employees = Employee::roots()->get();
            //dd($employees);
            //var_dump($employees);
            return EmployeeResource::collection($employees); 
            //$employees = Employee::get()->toHierarchy();
            //return EmployeeTreeResource::collection($employees); 
        } 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $temp = '%';
        $col = null;
        $sort = null;
        $search =  null;
        $salaryFrom = 0;
        $salaryTo = 0;
        $dateFrom = null;
        $dateTo = null;
        $cpar = false;
        
        if ($request->filled('c')) {
            $col = $request->c;
        }
        if ($request->filled('s')) {
            $sort = $request->s;
        }
        if ($request->filled('search')) {
            $search .= $temp;
            $search .= $request->search;
            $search .= $temp;
        }
        if ($request->filled('cpar')) {
            $cpar = $request->cpar;
        }
        if ($request->filled('searchst')) {
            $salaryTo = $request->searchst;
        }
        if ($request->filled('searchft')){
            $salaryFrom = $request->searchft;
        }
        if ($request->filled('df')){
            $dateFrom = $request->df;
        }
        if ($request->filled('dt')){
            $dateTo = $request->dt;
        }
        $employee = null;

        if ($cpar) {
            $employee = Employee::whereJoin('lastname', 'LIKE', $search)
                                ->orWhereJoin('firstname', 'LIKE', $search)
                                ->orWhereJoin('middlename', 'LIKE', $search)
                                ->orWhereJoin('salary', 'LIKE', $search)
                                ->orWhereJoin('position.name', 'LIKE', $search)
                                ->orWhereJoin('parent.lastname', 'LIKE', $search);
        }
        else {
            $employee = Employee::whereJoin('lastname', 'LIKE', $search)
                                ->orWhereJoin('firstname', 'LIKE', $search)
                                ->orWhereJoin('middlename', 'LIKE', $search)
                                ->orWhereJoin('salary', 'LIKE', $search)
                                ->orWhereJoin('position.name', 'LIKE', $search);
        }
        if ($salaryFrom > 0){
            $employee = $employee->whereJoin('salary', '>=', $salaryFrom);
        }
        if ($salaryTo > 0){
            $employee = $employee->whereJoin('salary', '<=', $salaryTo);
        }
        if ($dateFrom){
            $employee = $employee->whereJoin('employed_at', '>=', $dateFrom);           
        }
        if ($dateTo){
            $employee = $employee->whereJoin('employed_at', '<=', $dateTo);
        }

        if ($employee){
            $employee = $employee->orderByJoin($col, $sort)->paginate(15);           
        }
        else {
            $employee = Employee::orderByJoin($col, $sort)->paginate(15);  
        }

        return EmployeeResource::collection($employee);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $employee = Employee::create($request->all());        
        //$employee->makeChildOf($employee->parent_id);
        $employee->save();
        return $employee;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->all());
        $employee->save();

        return $employee;
        //return response()->json(['success'=>'Done!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        return new EmployeeResource($employee);

        // return EmployeeResource::collection($employee);
        //return Employee::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        // return EmployeeResource::$employee;
        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEmployeeRequest $request, $id)
    {
        $employee = Employee::find($id);

		if($employee->count()){
			 $employee->update($request->all());
			 return response()->json(['status'=>'success','msg'=>'Employee updated successfully.']);
		}else{
			 return response()->json(['status'=>'error','msg'=>'Error in updating Employee']);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
		if($employee->count()){
			$employee->delete();
			return response()->json(['status'=>'success','msg'=>'Employee deleted successfully']);
		}else{
			 return response()->json(['status'=>'error','msg'=>'Error in deleting Employee']);
		}
    }

    public function searchChiefs (Request $request){
        $temp = '%';
        //$id = 0;
        $search =  '';
        $employee = null;
        // if ($request->filled('id')) {
        //     $id = $request->id;
        // }
        if ($request->filled('query')) {
            $search = $temp;
            //$search .= $request->query;
            $search .= $request->get('query');
            $search .= $temp;
        }

        $employee = Employee::whereJoin('lastname', 'LIKE', $search)
                            ->orWhereJoin('firstname', 'LIKE', $search)
                            ->orWhereJoin('middlename', 'LIKE', $search)
                            ->get();
        return EmployeeResource::collection($employee);
    }
}
