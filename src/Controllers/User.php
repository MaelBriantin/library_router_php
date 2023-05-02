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

    public function update($id, $object)
    {
        $user = $this->find($id);
        $validateObject = $this->validate($object);
        $user['username'] = $validateObject['username'];
        $user['mail'] = $validateObject['mail'];
        $this->save($user);
        echo jsonResponse($user);
    }


    public function create($object)
    {
        $this->save($this->validate($object));
    }

    public function destroy($id): void
    {
        $this->delete($id);
    }

    public function libraries(int $id): void
    {
        $user = $this->find($id);
        $library = new Library();
        $user['library'] = $library->findAll($id, 'user_id');
        echo jsonResponse($user);
    }
}