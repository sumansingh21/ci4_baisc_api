<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StudetModel;
use PDO;

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

        $student_data = $this->checkStudentByEmail($email);

        if(!empty($student_data)){
            return $this->respond([
                "status" => false,
                "message" => "Email already exist !"
            ]);
        } else {
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
    }

    public function listStudents(){
        $students = $this->model->findAll();

        return $this->respond([
            "status" => true,
            "message" => "Student Data",
            "data" => $students
        ]);
    }

    public function getSingleStudentData($student_id){
        
        $students = $this->model->find($student_id);

        if(!empty($students)){
            return $this->respond([
                "status" => true,
                "message" => "Student Data",
                "data" => $students
            ]);
        } else {
            return $this->respond([
                "status" => False,
                "message" => "Student Data Not Found !",
            ]);
        }

    }

    public function updateStudent($student_id){
        $students = $this->model->find($student_id);

        if(!empty($students)){

            // $data = $this->request->getVar();
            $data = json_decode(file_get_contents("php://input"), true);

            $updated_data = [
                "name" => isset($data['name']) && !empty($data['name']) ? $data['name'] : $students['name'],
                "email" => isset($data['email']) && !empty($data['email']) ? $data['email'] : $students['email'],
                "phne_no" => isset($data['phne_no']) && !empty($data['phne_no']) ? $data['phne_no'] : $students['phone_no']
            ];

           if($this->model->update($student_id, $updated_data)){
            return $this->respond([
                "status" => True,
                "message" => "Student Data updated successfully",
            ]);
           } else {
            return $this->respond([
                "status" => False,
                "message" => "Student Data Not updated successfully",
            ]);
           }
        } else {
            return $this->respond([
                "status" => False,
                "message" => "Student Data Not Found with this id!",
            ]);
        }
    }

    public function deleteStudent($student_id){

        $student = $this->model->find($student_id);

        if(!empty($student)){
            $delete_student = $this->model->delete($student_id);
            if($delete_student){
                return $this->respond([
                    "status"=>True,
                    "message"=>"Student Deleted Successfully"
                ]);
            }
        }else{
            return $this->respond([
                "status"=>False,
                "message"=>"Student id not found"
            ]);
        }

    }

    //check student via Email Address 
    private function checkStudentByEmail($email){
       return $this->model->where("email",$email)->first();
    }
}
