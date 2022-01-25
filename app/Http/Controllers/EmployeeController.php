<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $text = trim($request->get('text'));
        $employee = DB::table('users')
        ->join('role_user', 'users.id', 'role_user.user_id')
        ->join('roles', 'roles.id', 'role_user.role_id')
        ->selectRaw('users.id as cod_us, users.cedula, users.name user_name, last_name, email, roles.name as rol_name')
        ->where('roles.name', '=', 'trabajador')
        ->where('cedula', 'LIKE', '%'.$text.'%')
        ->paginate(5);


        $request->user()->authorizeRoles(['admin']);
        return view('employee.index', compact('employee', 'text'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('employee.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        User::findOrFail($id)->delete();
        return redirect()->route('employee.index')->with('mensaje', 'Empleado eliminado con éxito');


    }

    public function regemployee(Request $request){
        $datauser = new User();
        $datauser->cedula = request()->get('cedula');
        $datauser->name = request()->get('name');
        $datauser->last_name = request()->get('last_name');
        $datauser->email = request()->get('email');
        $datauser->phone_number = request()->get('phone_number');
        $datauser->address = request()->get('address');
        //$datauser->role = 'trabajador';
        $datauser->password = Hash::make(request()->get('password'));
        $datauser->remember_token = request()->get('remember_token');
        $datauser->save();

        $datauser->roles()->attach(Role::where('name', 'trabajador')->first());

        $dataEmployee = new Employee();
        $dataEmployee->code = 'JB'.time();
        $dataEmployee->user_id = $datauser->id;
        $dataEmployee->save();

        return redirect()->route('employee.index')->with('success_msg', 'Trabajador creado!');

    }


}
