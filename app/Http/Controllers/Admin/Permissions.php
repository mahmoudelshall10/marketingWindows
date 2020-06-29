<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\PermissionsDataTable;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Permission;
use Validator;
use Set;
use Up;
use Form;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [It V 1.2 | https://it.phpanonymous.com]
// Copyright Reserved  [It V 1.2 | https://it.phpanonymous.com]
class Permissions extends Controller
{

            /**
             * Baboon Script By [It V 1.0 | https://it.phpanonymous.com]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(PermissionsDataTable $permissions)
            {
               return $permissions->render('admin.permissions.index',['title'=>trans('admin.permissions')]);
            }


            /**
             * Baboon Script By [It V 1.0 | https://it.phpanonymous.com]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {
               return view('admin.permissions.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [It V 1.0 | https://it.phpanonymous.com]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $r
             * @return \Illuminate\Http\Response
             */
            public function store()
            {
              $rules = [
             'name'=>'required|string',
             'display_name'=>'nullable|sometimes|string',
             'description'=>'nullable|sometimes|string',

                   ];
              $data = $this->validate(request(),$rules,[],[
             'name'=>trans('admin.name'),
             'display_name'=>trans('admin.display_name'),
             'description'=>trans('admin.description'),

              ]);
		
              Permission::create($data); 

              session()->flash('success',trans('admin.added'));
              return redirect(aurl('permissions'));
            }

            /**
             * Display the specified resource.
             * Baboon Script By [It V 1.0 | https://it.phpanonymous.com]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
                $permissions =  Permission::find($id);
                return view('admin.permissions.show',['title'=>trans('admin.show'),'permissions'=>$permissions]);
            }


            /**
             * Baboon Script By [It V 1.0 | https://it.phpanonymous.com]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
                $permissions =  Permission::find($id);
                return view('admin.permissions.edit',['title'=>trans('admin.edit'),'permissions'=>$permissions]);
            }


            /**
             * Baboon Script By [It V 1.0 | https://it.phpanonymous.com]
             * update a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $r
             * @return \Illuminate\Http\Response
             */
            public function update($id)
            {
                $rules = [
             'name'=>'required|string',
             'display_name'=>'nullable|sometimes|string',
             'description'=>'nullable|sometimes|string',

                         ];
             $data = $this->validate(request(),$rules,[],[
             'name'=>trans('admin.name'),
             'display_name'=>trans('admin.display_name'),
             'description'=>trans('admin.description'),
                   ]);
              Permission::where('id',$id)->update($data);

              session()->flash('success',trans('admin.updated'));
              return redirect(aurl('permissions'));
            }

            /**
             * Baboon Script By [It V 1.0 | https://it.phpanonymous.com]
             * destroy a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $r
             * @return \Illuminate\Http\Response
             */
            public function destroy($id)
            {
               $permissions = Permission::find($id);


               @$permissions->delete();
               session()->flash('success',trans('admin.deleted'));
               return back();
            }



 			public function multi_delete(Request $r)
            {
                $data = $r->input('selected_data');
                if(is_array($data)){
                    foreach($data as $id)
                    {
                    	$permissions = Permission::find($id);

                    	@$permissions->delete();
                    }
                    session()->flash('success', trans('admin.deleted'));
                   return back();
                }else {
                    $permissions = Permission::find($data);
 

                    @$permissions->delete();
                    session()->flash('success', trans('admin.deleted'));
                    return back();
                }
            }

            
}