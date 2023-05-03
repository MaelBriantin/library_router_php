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

    public function update($id, $request)
    {
        $user = $this->find($id);
        $user['username'] = $request['username'] ?? $user['username'];
        $user['mail'] = $request['mail'] ?? $user['mail'];
        $this->save($user);
        echo jsonResponse($user);
    }


    public function create($object)
    {
        $this->save($this->validate($object));
    }

    public function destroy($id): void
    {
        $this->delete(['user_id', '=', $id]);
    }

    public function libraries(int $id): void
    {
        $user = $this->find($id);
        $library = new Library();
        $user['library'] = $library->findAll($id, 'user_id');
        echo jsonResponse($user);
    }

    public function addBookToLibrary($id, $request)
    {
        $library = new Library();
        $newBook = $request;
        $newBook['reading_state_id'] = 1;
        $newBook['user_id'] = $id;
        //dd($newBook);
        $library->save($newBook);
    }
}