<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Modelmakanan;

class Makanan extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelMakanan = new Modelmakanan();
        $data = $modelMakanan->findAll();
        $response = [
            'status' => 200,
            'error' => "false",
            'message' => '',
            'totaldata' => count($data),
            'data' => $data,
        ];
        return $this->respond($response, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $modelMakanan = new Modelmakanan();
        $data = $modelMakanan -> orLike('id', $id) ->orLike('nama_makanan', $id)->get()->getResult();
        if(count($data) > 1) {
                $response = [
                    'status' => 200,
                    'error' => "false",
                    'message' => '',
                    'totaldata' => count($data),
                    'data' => $data,
                ];
                return $this->respond($response, 200);
        }else if(count($data) == 1) {
                    $response = [
                        'status' => 200,
                        'error' => "false",
                        'message' => '', 
                        'totaldata' => count($data),
                        'data' => $data,
         ];
            return $this->respond($response, 200);
        }else {
            return $this->failNotFound('maaf data ' . $id .' tidak ditemukan');
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $modelMakanan = new Modelmakanan();
        $nama_makanan = $this->request->getPost("nama_makanan");
        $harga = $this->request->getPost("harga");
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'nama_makanan' => 'required',
            'harga' => 'required',
                ]);
                if(!$valid){
                    $response = [
                    'status' => 404,
                    'error' => true,
                    'message' => $validation->getError(),
                    ];
                
                return $this->respond($response, 404);
                }else {
                    $modelMakanan->insert([
                        'nama_makanan' => $nama_makanan,
                        'harga' => $harga,
                    ]);

                    $response = [
                        'status' => 201,
                        'error' => "false",
                        'message' => "Data berhasil disimpan"
                    ];
                    return $this->respond($response, 201);
                    
                    }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $model = new Modelmakanan();
        $data = [
            'nama_makanan' => $this->request->getVar("nama_makanan"),
             'harga' => $this->request->getVar("harga"),
        ];
        $data = $this->request->getRawInput();
        $model->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'message' => "Data Anda dengan nama makanan $id berhasil diupdate"
            ];
            return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $modelMakanan = new Modelmakanan();

        $cekData = $modelMakanan->find($id);
        if($cekData) {
            $modelMakanan->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => "Selamat data makanan id $id sudah berhasil dihapus"
            ];
            return $this->respondDeleted($response);
        }else {
        return $this->failNotFound('Data tidak ditemukan kembali');
        }
    }
}
