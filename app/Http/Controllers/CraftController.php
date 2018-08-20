<?php

namespace App\Http\Controllers;

use App\Craft;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;

class CraftController extends Controller
{
    public function index(Request $request)
    {
        if($request->query('id'))
            return $this->show($request->query('id'), 200);

        if($request->query('name'))
            return $this->search($request->query('name'));

        $craftsDto = Craft::all();

        foreach($craftsDto as $key => $craft) {
            $craftsDto[$key]['author'] = User::findOrFail($craft['author_id'])->only(['id', 'name']);
        }

        return $craftsDto;
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'image_url' => 'required'
            ]);

            if ($validator->fails()) {
                return response(['messages' => $validator->errors()->all()], 400);
            }

            $craft = new Craft();
            $craft->fill($request->all());
            $craft['author_id'] = User::inRandomOrder()->get()->first()->id;

            $craft->save();

            return response($craft, 201);
        }
        catch (\Exception $e) {
            return response(['messages' => [$e->getMessage()]], 400);
        }
    }

    public function show($id, $notFoundStatusCode = 404)
    {
        if(!$craft = Craft::find($id))
            return response([], $notFoundStatusCode);
        $craft['author'] = User::find($craft['author_id']);
        return response($craft);
    }

    public function search($term)
    {
        $crafts = Craft::where('name', 'like', '%'.$term.'%')->get();
        return response($crafts);
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'image_url' => 'required',
            ]);

            if ($validator->fails()) {
                return response(['messages' => $validator->errors()->all()], 400);
            }

            if(!$craft = Craft::find($id))
                throw new \Exception('No record with given id found');

            $craft = Craft::find($id);

            $craft->fill($request->all());

            $craft->save();

            return response($craft, 200);
        }
        catch (\Exception $e) {
            return response(['messages' => ['Wrong input']], 400);
        }
    }

    public function destroy($id)
    {
        try {
            if(!$craft = Craft::find($id))
                throw new \Exception('No record with given id found');
            $craft->delete();
            return response(['messages' => ["Record with id $id removed"]], 200);
        }
        catch (\Exception $e) {
            return response(['messages' => [$e->getMessage()]], 400);
        }
    }

    public function homePageCrafts($page, $count = 20) {
        $craftsDto = Craft::skip(($page-1)*$count)->take($count)->get();

        foreach($craftsDto as $key => $craft) {
            $craftsDto[$key]['author'] = User::findOrFail($craft['author_id']);
        }

        return ['crafts' => $craftsDto];
    }
}
