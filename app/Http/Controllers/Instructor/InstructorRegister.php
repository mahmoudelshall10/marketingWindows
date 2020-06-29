<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Instructor;
use App\Model\Answer;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Model\Question;
use Illuminate\Support\Facades\Session;
use App\Notifications\InstructorSignupActivate;
use Illuminate\Support\Str;
class InstructorRegister extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/instructor';

    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:instructor');
    }
    public function showInstructorRegisterForm()
    {
        $Questions = Question::all();
        $Answers = Answer::all();
        return view('instructor.register', ['url' => 'instructor'],compact('Questions','Answers'));
    }

    protected function createInstructor()
    {
        $instructor = $this->validate(request(),
			[
                'name'                  => 'required|string|max:255',
                'username'              => 'required|string|max:30|unique:instructors',
                'email'                 => 'required|string|email|max:255|unique:instructors',
                'password'              => 'required|string|confirmed|min:8',
                'password_confirmation' => '',
			], [], [
                'name'                  => trans('instructor.name'),
                'username'              => trans('instructor.username'),
                'email'                 => trans('instructor.email'),
				'password'              => trans('instructor.password'),
                'password_confirmation' => trans('instructor.password_confirmation'),
            ]);
            $instructor['password'] = Hash::make(request('password')); 
            $instructor['activation_token'] = Str::random(60);
            $instructor = Instructor::create($instructor);
            $instructor->notify(new InstructorSignupActivate($instructor));
            return redirect('/instructor');
        }

        public function signupActivate($token)
        {
            $instructor = Instructor::where('activation_token', $token)->first();
            if (!$instructor) {
                return response()->json([
                    'message' => 'This activation token is invalid.'
                ], 404);
            }
            $instructor->account_status = true;
            $instructor->activation_token = '';
            $instructor->save();
            // return $instructor;
            // session()->flash('success', 'Activated Successfully!');
            return redirect('/instructor');
        }

}
