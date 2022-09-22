<?php
namespace App\Controllers\Apis;

use App\Models\DepartamentosM;
use CodeIgniter\RESTful\ResourceController;

class Departamentos extends ResourceController
{
    public function addDept()
    {
        $rules = [
            'NombreDepRol' => 'required|alpha_space|min_length[5]|max_length[100]',
        ];

        $messages = [
            'NombreDep' => [
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
            $Dept = new DepartamentosM();

            $data['NombreDep'] = $this->request->getVar("NombreDep");

            $Dept->save($data);

            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Dept agregado correctamente',
                'data' => []
            ];
        }

        return $this->respondCreated($response);
    }

    public function listDept()
    {
        $emp = new DepartamentosM();

        $response = [
            'status' => 200,
            'error' => false,
            'message' => 'Listado de Depts',
            'data' => $emp->findAll()
        ];

        return $this->respondCreated($response);
    }

    public function selectDept($id)
    {
        $Dept = new DepartamentosM();

        $data = $Dept->find($id);

        if(!empty($data)) {
            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Datos de Dept',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 500,
                "error" => true,
                'message' => 'No se ha encontrado el Dept',
                'data' => []
            ];
        }

        return $this->respondCreated($response);
    }

    public function updateDept($id)
    {
        $rules = [
            'NombreDep' => 'required|alpha_space|min_length[5]|max_length[100]',
        ];

        $messages = [
            'NombreDep' => [
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
            $Dept = new DepartamentosM();

            if ($Dept->find($id)){

                $data['nombre'] = $this->request->getVar("NombreDep");

                $Dept->update($id, $data);

                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'Dept actualizado correctamente',
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => 500,
                    "error" => true,
                    'messages' => 'Ningun Dept encontrado',
                    'data' => []
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function borrarDept($id)
    {
        $Dept = new DepartamentosM();

        $data = $Dept->find($id);

        if(!empty($data)){
            $Dept->delete($id);

            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Dept eliminado con exito',
                'data' => []
            ];
        } else{
            $response = [
                'status' => 500,
                "error" => true,
                'messages' => 'Dept no encontrado',
                'data' => []
            ]; 
        }

        return $this->respondCreated($response);
    }
}
