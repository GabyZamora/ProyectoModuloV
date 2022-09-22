<?php
namespace App\Controllers\Apis;

use App\Models\RolesM;
use CodeIgniter\RESTful\ResourceController;

class Roles extends ResourceController
{
    public function addRol()
    {
        $rules = [
            'NombreRol' => 'required|alpha_space|min_length[5]|max_length[100]',
        ];

        $messages = [
            'NombreRol' => [
                "required" => "El nombre debe agregarse",
                'alpha_space' => 'El nombre debe contener al menos 5 caracteres' 
            ],
        ];

        if (!$this->validate($rules, $messages)){
            $response = [
                'status' =>500,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
        } else {
            $Rol = new RolesM();

            $data['NombreRol'] = $this->request->getVar("NombreRol");

            $Rol->save($data);

            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Rol agregado correctamente',
                'data' => []
            ];
        }

        return $this->respondCreated($response);
    }

    public function listRol()
    {
        $emp = new RolesM();

        $response = [
            'status' => 200,
            'error' => false,
            'message' => 'Listado de Roles',
            'data' => $emp->findAll()
        ];

        return $this->respondCreated($response);
    }

    public function selectRol($id)
    {
        $Rol = new RolesM();

        $data = $Rol->find($id);

        if(!empty($data)) {
            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Datos de Rol',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 500,
                "error" => true,
                'message' => 'No se ha encontrado el Rol',
                'data' => []
            ];
        }

        return $this->respondCreated($response);
    }

    public function updateRol($id)
    {
        $rules = [
            'NombreRol' => 'required|alpha_space|min_length[5]|max_length[100]',
        ];

        $messages = [
            'NombreRol' => [
                "required" => "El nombre debe agregarse",
            ],
        ];
        
        if (!$this->validate($rules, $messages)) {
            $response = [
                'status' =>500,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
        } else {
            $Rol = new RolesM();

            if ($Rol->find($id)){

                $data['nombre'] = $this->request->getVar("nombre");

                $Rol->update($id, $data);

                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'Rol actualizado correctamente',
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => 500,
                    "error" => true,
                    'messages' => 'Ningun Rol encontrado',
                    'data' => []
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function borrarRol($id)
    {
        $Rol = new RolesM();

        $data = $Rol->find($id);

        if(!empty($data)){
            $Rol->delete($id);

            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Rol eliminado con exito',
                'data' => []
            ];
        } else{
            $response = [
                'status' => 500,
                "error" => true,
                'messages' => 'Rol no encontrado',
                'data' => []
            ]; 
        }

        return $this->respondCreated($response);
    }
}
