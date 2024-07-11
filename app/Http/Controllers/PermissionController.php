<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use ReflectionFunctionAbstract;
use Spatie\Permission\Models\Permission;
class PermissionController extends Controller
{
    use HttpResponses;

    public function fetchAll()
    {
        $permissions = Permission::get();

        return $this->success($permissions, 'Permissions retrieved successfully', 200);

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $request -> validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]

        ]);
        Permission::create([
            'name' => $request-> name,
    
        ]);

        return $this->success('Success', 'Permission successfully created', 200);
       }

       public function update(Request $request, $id)
       {
           $permission = Permission::findOrFail($id);
   
           $request->validate([
               'name' => 'required|string|unique:permissions,name,' . $id,
           ]);
   
           $permission->update($request->all());
   
           return $this->success($permission, 'Permission updated successfully', 200);
       }
   

    public function show($id)
    {

        $permission = Permission::findOrFail($id);

        return $this->success($permission, 'Permission retrieved successfully', 200);

    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        $permission->delete();

        return $this->success(null, 'Permission deleted successfully', 200);
    }
}
