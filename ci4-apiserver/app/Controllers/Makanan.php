<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

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
    public function show($cari = null)
    {
        $modelMakanan = new Modeluser();
        $data = $modelMakanan->orLike('id', $cari) ->orLike('makanan', $cari)->get()->getResult();
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
            return $this->failNotFound('maaf data ' . $cari .' tidak ditemukan');
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
        $modelMakanan = new ModelMakanan();
        $id = $this->request->getPost("id");
        $nama_makanan = $this->request->getPost("nama_makanan");
        $harga = $this->request->getPost("harga");
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'id' => [
                'rules' => 'is_unique[makanan.id]',
                'label' => 'Id Makanan',
                'errors' => [
                    'is_unique' => "{field} sudah ada"
                    ]

            ]
                ]);
                if(!$valid){
                    $response = [
                    'status' => 404,
                    'error' => true,
                    'message' => $validation->getError("id"),
                    ];
                
                    return $this->respond($response, 404);
                }else {
                    $modelUsr->insert([
                        'id' => $id,
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
        $model = new ModelMakanan();
        $data = [
            'nama_makanan' => $this->request->getVar("nama_makanan"),
             'harga' => $this->request->getVar("harga"),
        ];
        $data = $this->request->getRawInput();
        $model->update($id, $data);

        $response = [
            'status' => 200,
            'error' => null,
            'message' => "Data Anda dengan nama makanan $nama_makanan berhasil diupdate"
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
        //
    }
}
