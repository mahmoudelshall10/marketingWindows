<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\RolesDataTable;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Role;
use Validator;
use Set;
use Up;
use Form;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [It V 1.2 | https://it.phpanonymous.com]
// Copyright Reserved  [It V 1.2 | https://it.phpanonymous.com]
class Roles extends Controller
{

            /**
             * Baboon Script By [It V 1.0 | https://it.phpanonymous.com]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(RolesDataTable $roles)
            {
               return $roles->render('admin.roles.index',['title'=>trans('admin.roles')]);
            }


            /**
             * Baboon Script By [It V 1.0 | https://it.phpanonymous.com]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {
               return view('admin.roles.create',['title'=>trans('admin.create')]);
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
		
              Role::create($data); 

              session()->flash('success',trans('admin.added'));
              return redirect(aurl('roles'));
            }

            /**
             * Display the specified resource.
             * Baboon Script By [It V 1.0 | https://it.phpanonymous.com]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
                $roles =  Role::find($id);
                return view('admin.roles.show',['title'=>trans('admin.show'),'roles'=>$roles]);
            }


            /**
             * Baboon Script By [It V 1.0 | https://it.phpanonymous.com]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
                $roles =  Role::find($id);
                return view('admin.roles.edit',['title'=>trans('admin.edit'),'roles'=>$roles]);
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
              Role::where('id',$id)->update($data);

              session()->flash('success',trans('admin.updated'));
              return redirect(aurl('roles'));
            }

            /**
             * Baboon Script By [It V 1.0 | https://it.phpanonymous.com]
             * destroy a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $r
             * @return \Illuminate\Http\Response
             */
            public function destroy($id)
            {
               $roles = Role::find($id);


               @$roles->delete();
               session()->flash('success',trans('admin.deleted'));
               return back();
            }



 			public function multi_delete(Request $r)
            {
                $data = $r->input('selected_data');
                if(is_array($data)){
                    foreach($data as $id)
                    {
                    	$roles = Role::find($id);

                    	@$roles->delete();
                    }
                    session()->flash('success', trans('admin.deleted'));
                   return back();
                }else {
                    $roles = Role::find($data);
 

                    @$roles->delete();
                    session()->flash('success', trans('admin.deleted'));
                    return back();
                }
            }

            
}