<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'number' => 'required',
        ]);

        $client = [
            'name' => $request['name'],
            'address' => $request['address'],
            'number' => $request['number'],
        ];

        if (Client::create($client)) {
            echo 'Data Inserted';
        } else {
            echo 'Something Went Wrong';
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function get_data()
    {
        $client = Client::get();
        $data = '';
        foreach ($client as $clt) {
            $data .= '<tr>
                        <th class="text-center" id="'.$clt->id.'" scope="row">'.$clt->id.'</th>
                        <td class="text-center">'.$clt->name.'</td>
                        <td class="text-center">'.$clt->address.'</td>
                        <td class="text-center">'.$clt->number.'</td>
                        <td class="text-center edit" data="'.$clt->id.'"><button class="btn-sm btn-primary">Edit</button></td>
                        <td class="text-center delete" data="'.$clt->id.'"><button class="btn-sm btn-danger">Delete</button></td>
                    </tr>';
        }
        echo $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $client = Client::find($request->id);

        $data = '
                    <div class="modal-body bg-dark">
                        <div class="">
                        <input type="hidden"
                            class="form-control" name="name" id="id" value="'.$client->id.'" aria-describedby="helpId" placeholder="Enter Your Name...">
                        </div>
                        <div class="mb-3">
                        <label for="" class="form-label text-white ">Name</label>
                        <input type="text"
                            class="form-control" name="name" id="name" value="'.$client->name.'" aria-describedby="helpId" placeholder="Enter Your Name...">
                        </div>
                        <div class="mb-3">
                        <label for="" class="form-label text-white ">Address</label>
                        <input type="text"
                            class="form-control" name="address" id="address" value="'.$client->address.'" aria-describedby="helpId" placeholder="Enter Your Address...">
                        </div>
                        <div class="mb-3">
                        <label for="" class="form-label text-white ">Number</label>
                        <input type="text"
                            class="form-control" name="number" id="number" value="'.$client->number.'" aria-describedby="helpId" placeholder="Enter Your Number...">
                        </div>
                    </div>
                <div class="modal-footer bg-dark">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="submit" data="'.$client->id.'" class="btn btn-primary">Update Data</button>
                </div>
        ';
        echo $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request)
    {
        $client = Client::find($id);
        $client->name = $request->name;
        $client->address = $request->address;
        $client->number = $request->number;
        $client->save();


        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::find($id)->delete();

        return response()->json($client);
    }
}
