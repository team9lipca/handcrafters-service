<?php

namespace App\Http\Controllers;

use App\Craft;
use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
use Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->query('id'))
            return $this->show($request->query('id'), 200);

        if($request->query('name'))
            return $this->search($request->query('name'));

        return User::all();
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'login' => 'required|unique:users,login',
                'email' => 'required|unique:users,email|email',
                'password' => 'required|min:4'
            ]);

            if ($validator->fails()) {
                return response(['messages' => $validator->errors()->all()], 400);
            }

            $request['password'] = bcrypt($request['password']);
            $user = new User($request->all());

            $user->save();

            $user = User::find($user['id']);

            return response($user, 201);
        }
        catch (\Exception $e) {
            return response(['messages' => [$e->getMessage()]], 400);
        }
    }

    public function show($idOrLogin, $notFoundStatusCode = 404)
    {
        $user = User::where(['id' => $idOrLogin])->first();
        if(!$user) {
            $user = User::where(['login' => $idOrLogin])->first();
        }

        if(!$user) {
            return response([], $notFoundStatusCode);
        }

        $user['shots'] = Craft::where(['author_id' => $user['id']])->orderBy('created_at')->take(5)->get();

        return response($user, 200);
    }

    public function search($term)
    {
        try {
            $users = User::whereRaw("CONCAT(`name`, ' ', `surname`) like ?", ["%" . $term . "%"])
                ->orWhere('login', 'like', '%' . $term . '%')
                ->get();

            return response($users);
        }
        catch (\Exception $e) {
            return response(['messages' => [$e->getMessage()]], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'login' => 'required|unique:users,login',
                'email' => 'required|unique:users,email|email',
                'password' => 'required|min:4'
            ]);

            if ($validator->fails()) {
                return response(['messages' => $validator->errors()->all()], 400);
            }

            if(!$user = User::find($id))
                throw new \Exception('No record with given id found');

            $request['password'] = bcrypt($request['password']);

            $user->fill($request->all());

            $user->save();

            return response($user, 201);
        }
        catch (\Exception $e) {
            return response(['messages' => ['Wrong input']], 400);
        }
    }

    public function destroy($id)
    {
        try {
            if(!$user = User::find($id))
                throw new \Exception('No record with given id found');
            $user->delete();
            return response(['messages' => ["Record with id $id removed"]], 200);
        }
        catch (\Exception $e) {
            return response(['messages' => [$e->getMessage()]], 400);
        }
    }

    public function mostPopularCrafters($page, $count = 10) {
        $usersDto = User::skip(($page-1)*$count)->take($count)->get();

        foreach($usersDto as $key => $user) {
            $usersDto[$key]['last-crafts'] = Craft::where(['author_id' => $user['id']])->orderBy('created_at')->take(5)->get();
        }

        return ['crafters' => $usersDto];
    }
}
