<?php
namespace Controllers;

class User extends \Models\User
{
    public function index()
    {
        echo jsonResponse($this->findAll());
    }

    public function show($id)
    {
        echo jsonResponse($this->find($id));
    }

    public function update($object, $id)
    {
        //
    }


    public function create($object)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function library($id)
    {
        $result = $this->find($id);
        $library = new Library();
        $result['library'] = $library->find($id);
        echo jsonResponse($result);
    }
}