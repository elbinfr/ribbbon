<?php

class HomeController extends BaseController {

	// Depending if the user is signed in or not, return the home page 
	public function index(){
		if( Auth::check() ) {
			$pTitle			=	"Hud";

			$latestTasks	=	Task::where('user_id', Auth::id())->where('state','incomplete')->orderBy('created_at', 'desc')->take(5)->get();
			$latestProjects	=	Project::where('user_id', Auth::id())->orderBy('created_at', 'desc')->take(5)->get();

			$user 		= User::find(Auth::id());
			$inProjects =  $user->inProjects()->orderBy('created_at', 'desc')->take(5)->get();



			return View::make('hud', compact('pTitle', 'latestProjects', 'latestTasks', 'inProjects'));
		}else{
			return View::make('index')->with('pTitle', "A project management system for artisans");
		}
	}

	/**
	 * Run a general search.
	 * @return  array of objects with the search results.
	 */
	public function search(){

		$q = Input::get("q");
		$clients = Client::where('name', 'like', '%'.$q.'%')->get();		
		$projects = Project::where('name', 'like', '%'.$q.'%')->get();		
		$tasks = Task::where('name', 'like', '%'.$q.'%')->get();		
		$pTitle = "Search Results";

		return View::make('search', compact('q','clients','projects','tasks','pTitle'));
	}
}
