<?php
namespace Controllers;

class User extends \Models\User
{
    public function index()
    {
        echo jsonResponse($this->all());
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

    public function libraries($id): void
    {
        $result = $this->find($id);
        $library = new Library();
        $result[singularize('libraries')] = $library->findAll($id);
        echo jsonResponse($result);
    }
}