<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('project.list', ['user' => Auth::user()]);
    }

    public function userList($id)
    {
        $usersProject = Project::find($id)->users()->pluck('email');
        return response()->json( $usersProject);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($redirect = null)
    {
        
        return view('project.form', ['redirect' => $redirect]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = Project::create($request->except(['_token', 'redirect']) + ['creator_id' => Auth::id()]);
        $project->users()->attach(Auth::id());
        if($request->input('redirect') == "new") {
            return redirect(route('projects.index'))->with('success', 'Project created successfully');
        } else {
            return redirect(route('createTicket', ['id' => $request->input('redirect')]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->isAttachedToProject($id)){
            $project = Project::find($id);
            return view('project.show', ['project' => $project]);
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addUserToProject(Request $request)
    {   
        $project = Project::find($request->input('projectid'));
        if($project->isOwner(Auth::id())) {
            $response = $project->addUser($request->input('user'));
        } else {
            return ['status'=>'error', "msg" => "You are not owner of this project"];
        }
        return response()->json($response);
    }

    public function deleteUserToProject(Request $request)
    {   
        $project = Project::find($request->input('projectid'));
       
        if($project->isOwner(Auth::id())) {
            $response = $project->deleteUser($request->input('user'));
        } else {
            return ['status'=>'error', "msg" => "You are not owner of this project"];
        }

        return response()->json($response);
    }
}

  // $project->save();
        //  $user = User::find(Auth::id());
          //getting the current logged in user
       
        //   dump($user->givePermissionsTo('edit-users'));// will return permission, if not null
        //   dump($user->can('edit-users'));
        //  dd($user->projects);
        // $project = new Project;
        // $project->name = 'God of War';
        // $project->description = "23123";
        // $project->creator_id = 0;
       
    
        // $project->users()->attach($user);
        
    //    dd(Project::all()[1]->users);
