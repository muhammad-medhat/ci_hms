<?php namespace App\Controllers;

use App\Models\TodoModel;

class Todos extends BaseController{

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->todos_model = new TodoModel();
        $this->perpage=10;
    }
    public function index(){
        
        return  $this->show_todos();
    }

    public function delete($id){
        $mtd  = $this->request->getMethod();
        $task = $this->todos_model->asObject()->find($id);

        // echo $this->db->getLastQuery();
        if($this->todos_model->delete($id)){
            $session = session();  
            $session->setFlashdata('method', $mtd);
            $session->setFlashdata('success', "Item withh id ($id) has been deleted");
            return redirect()->to(site_url('todos/index'));
        } else {
            session()->setFlashdata('error', 'Cant delete');
        }
    }

    public function update($id){

        $mtd  = $this->request->getMethod();               
        $task = $this->todos_model->asObject()->find($id);
        //dump_obj($task, 'Task to update');
        //echo $mtd;
        switch($mtd){
            case 'post': 
                // $data_update = $this->request->getPost();
                $data_update = [
                    'name'=>$this->request->getVar('name'), 
                    'description'=>$this->request->getVar('description'), 
                    'done'=> (null !== $this->request->getVar('done'))?1: 0                    
                ];

                // dump_obj($data_update, 'update');

                //DB Update   
                $session = session();  
                $session->setFlashdata('method', $mtd);
                if($this->todos_model->where(['id'=>$id])->set($data_update)->update()){

                    echo $this->db->getLastQuery();

                    $alert = (object)array(
                        'class' =>'alert-success',
                        'message'=> 'Task Updated Successfully'
                    );
                } else {
                    $alert = (object)array(
                        'class' =>'alert-danger',
                        'message'=> 'Cant Update Task'
                    );
                }
                // dump_obj($data);

                return $this->show_todos($alert);

            default:
                $title = 'Update a task';
                return view('todos_form', 
                array(
                    'title'=>$title, 
                    'task'=>$task, 
                    'method'=> $mtd, 
                    'action'=>"todos/update/$id")
                );

    }
}
    public function insert(){
        //$this->dump_obj($this->request);
        $mtd  = $this->request->getMethod();
        // echo $mtd;
        switch($mtd){
            case 'post': 
                //DB Insert
                $data=array(
                    'name'=>$this->request->getVar('name'), 
                    'description'=>$this->request->getVar('description'), 
                    'done'=> $this->request->getVar('done')  //==false )? 0: 1
                );     
                $session = session();              
                //$this->dump_obj($data);
                if($this->todos_model->insert($data)){
                    $alert = (object)array(
                        'class' =>'alert-success',
                        'message'=> 'Task Added Successfully'
                    );
                } else {
                    $alert = (object)array(
                        'class' =>'alert-danger',
                        'message'=> 'Cant Add Task'
                    );
                }
                // dump_obj($data);

                return $this->show_todos($alert);

            default:
                $title = 'Insert a task';
                return view('todos_form', 
                    array(
                        'title'=>$title, 
                        'method'=> $mtd, 
                        'action'=>'todos/insert'

            ));
        }

    }

    function get_todos(){
        return $this->todos_model->asObject()->paginate($this->perpage);        
    }



    function show_todos($alert=''){
        $mtd  = $this->request->getMethod();               


        $title = 'Todos list';
        $todos=$this->get_todos();
        return view('todo_list', 
            array(
                'method'=>$mtd,
                'title'=>$title, 
                'todos'=>$todos, 
                'alert'=>$alert,
                'pager'=>$this->todos_model->pager
            )
        );
    }

}
