<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StudetModel;

class StudentController extends ResourceController
{
    protected $modelName = "App\Models\StudetModel";
    protected $format = "json";
    
    public function addStudent(){
        $data = $this->request->getPost();

        $name = isset($data['name']) ? $data['name'] : '';
        $email = isset($data['email']) ? $data['email']:'';
        $phone_no = isset($data['phone']) ? $data['phone']:'';

        if(empty($name) || empty($email)){
            return $this->respond([
                "status" => false,
                "message" => "Please provide the required fields (name, email)"
            ]);
        }

        if ($this->model->insert([
            "name" => $name,
            "email" => $email,
            "phone_no" => $phone_no
        ])) {
            return $this->respond([
                "status" => true,
                "message" => "Successfully, Student has been created"
            ]);
        } else {
            return $this->respond([
                "status" => false,
                "message" => "Failed to add student"
            ]);
        }
    }

    public function listStudents(){

    }

    public function getSingleStudentData($student_id){

    }

    public function updateStudent($student_id){

    }

    public function deleteStudent($student_id){

    }
}
