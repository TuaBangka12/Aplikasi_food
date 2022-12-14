<?php

namespace App\Controllers;


use App\Models\Modeluser;
use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelUsr = new Modeluser();
        $data = $modelUsr->findAll();
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
    public function show($cari=null){
        $modelUsr = new Modeluser();
        $data = $modelUsr->orLike('id', $cari) ->orLike('user', $cari)->get()->getResult();
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
        $modelUsr = new ModelUser ();
        $id = $this->request->getPost("id");
        $user = $this->request->getPost("user");
        $password = $this->request->getPost("password");
        $email = $this->request->getPost("email");
        $tanggal_lahir= $this->request->getPost("tanggal_lahir");
        $nomorHP = $this->request->getPost("nomorHP");

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'id' => [
                'rules' => 'is_unique[user.id]',
                'label' => 'Id User',
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
                        'user' => $user,
                        'password' => $password,
                        'email' => $email,
                        'tanggal_lahir' => $tanggal_lahir,
                        'nomorHP' => $nomorHP,
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

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $model = new ModelUser();
        $data = [
            'user' => $this->request->getVar("user"),
            'password' => $this->request->getVar("password"),
            'email' => $this->request->getVar("email"),
            'tanggal_lahir' => $this->request->getVar("tanggal_lahir"),
            'nomorHP' => $this->request->getVar("nomorHP"),
        ];
        $data = $this->request->getRawInput();
        $model->update($id, $data);

        $response = [
            'status' => 200,
            'error' => null,
            'message' => "Data Anda dengan username $user berhasil diupdate"
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
        $modelUsr = new Modeluser();

        $cekUser = $modelUsr->find($id);
        if($cekUser){
            $modelUsr->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => "Selamat data sudah berhasil terhapus"
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Data tidak ditemukan kembali');
        }
    }

   

    public function login($cari=null){
            $modelUsr = new ModelUser();
            $user = $this->request->getPost('user');
            $password = $this->request->getPost('password');
            $cari = $modelUsr->where('user', $user)->first();
            if($cari){
                $pass = $cari['password'];
                $verify_pass = $password == $pass;
                if($verify_pass){
                    $response = [
                        'status' => 200,
                        'error' => false,
                        'massage' => 'Login telah berhasil',
                        'data'     => $cari
                    ];
                    return $this->respond($response, 200);
                }else{
                   
                    return $this->failNotFound('Password anda salah');
                }
            }else{
                return $this->failNotFound('Username tidak ditemukan');
            }
        }

    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }

    public function register(){
        {
            //include helper form
            helper(['form']);
            //set rules validation form
            $rules = [
                'user'          => 'required|min_length[3]|max_length[20]',
                'password'      => 'required',
                'email'         => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.user_email]',
                'tanggal_lahir' => 'required',
                'nomorHP'      => 'required|max_length[13]',
                'confpassword'  => 'matches[password]'
            ];
             
            if($this->validate($rules)){
                $modelUsr = new ModelUser();
                $data = [
                    'username'     => $this->request->getVar('user'),
                    'user_email'    => $this->request->getVar('email'),
                    'tanggal_lahir' => $this->request->getVar('tanggal lahir'),
                    'nomorHP' => $this->request->getVar('nomorHP'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
                ];
                $model->register($data);
            }else{
                $data['validation'] = $this->validator;
                echo view('register', $data);
            }
        }

    }

}
