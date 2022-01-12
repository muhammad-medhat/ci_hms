<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TodoModel;


class RestTodos extends ResourceController
{
	public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->todos_model = new TodoModel();

        // $this->supportedResponseFormats = [
		// 	'application/json',
		// 	'application/xml'
		// ];
		header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
    }
	/**
	 * Return an array of resource objects, themselves in array format
	 *
	 * @return mixed
	 */
	public function index(){

		$ret = $this->todos_model->orderBy('id', 'desc')->findAll();    
		$n = count($ret)    ;
		$response = [
            'status' => 200,
            'error' => null,
            'messages' => "index get all $n Todos",
            "data" => $ret,
        ];
        return $this->respond($response); 
        // return $this->setResponseFormat('xml')->respond($response); 

	}

	/**
	 * Return the properties of a resource object
	 *
	 * @return mixed
	 */
	public function show($id = null)
	{
		// print"show id: '$id'";
		if( $id!=''){
			$task = $this->todos_model->find($id);
			if($task){
				return $this->respond($task);
			} else{
				return $this->failNotFound("No Data xxx Found with id='$id'");
			}
		} else {
			return $this->index();
		}
	}
	public function new(){
		echo"New todo item";
		$this->create();
	}

	/**
	 * Create a new resource object, from "posted" parameters
	 *
	 * @return mixed
	 */
	public function create()
	{
		$data=array(
			'name'=>$this->request->getVar('name'), 
			'description'=>$this->request->getVar('description'), 
			'done'=> $this->request->getVar('done')  
		);  
		$id = $this->todos_model->insert($data);
		$data['id'] = $id;

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => "todo created",
			'data'=> $data
        ];
        return $this->respondCreated($response);
	}

	/**
	 * Return the editable properties of a resource object
	 *
	 * @return mixed
	 */
	public function edit($id = null)
	{
		$data=array(
			'name'=>$this->request->getVar('name'), 
			'description'=>$this->request->getVar('description'), 
			'done'=> $this->request->getVar('done')  
		);
		$this->todos_model->update($id, $data);
		$update_query = $this->db->getLastQuery();
		$new = $this->todos_model->find($id);
		$response = [
            'status' => 200,
            'error' => null,
            'messages' => "Data Updated",
			'query'=>$update_query, 
			'updated'=>$new
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
		$task = $this->todos_model->find($id);
		$res = [];        
        if($task){
			$this->todos_model->delete($id);
			$res = [
                'status' => 200,
                'error' => null,
                'messages' => "Data Deleted",
				'query' => $this->db->getLastQuery()->getQuery()
            ];
            return $this->respondDeleted($res);
		} else{
            return $this->failNotFound('No Data Found with id ' . $id);

		}
		
	}
	public function info(){
		// return 'xxxxxxxxx';
		phpinfo();
	}
}
