<?php
namespace Controllers;

use Models\Comment;
use Models\Wishlist;

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
        $newBook['added_at'] = date('Y-m-d');
        $newBook['user_id'] = $id;
        $library->save($newBook);
    }

    public function removeBookFromLibrary($id, $request)
    {
        $bookToRemove = $request['bookVersionId'];
        $library = new Library();
        $library->delete(['user_id', '=', $id], ['book_version_id', '=', $bookToRemove]);
        $this->libraries($id);
    }

    public function wishlists(int $id): void
    {
        $user = $this->find($id);
        $wishlist = new Wishlist();
        $user['wishlist'] = $wishlist->findAll($id, 'user_id');
        echo jsonResponse($user);
    }

    public function addBookToWishlist($id, $request)
    {
        $wishlist = new Wishlist();
        $newBook = $request;
        $newBook['user_id'] = $id;
        $wishlist->save($newBook);
    }

    public function removeBookFromWishlist($id, $request)
    {
        $bookToRemove = $request['bookVersionId'];
        $wishlist = new Wishlist();
        $wishlist->delete(['user_id', '=', $id], ['book_version_id', '=', $bookToRemove]);
        $this->wishlists($id);
    }

    public function showReviews($id)
    {
        $reviews = new Comment();
        echo jsonResponse(only(['id', 'review', 'comment', 'bookTitle'], $reviews->findAll($id, 'user_id'), true));
    }

    public function postReview($id, $request)
    {
        $newReview['book_id'] = $request['bookId'];
        $newReview['user_id'] = $id;
        $newReview['comment'] = $request['comment'] ?? abort(400, 'missing required element');
        $newReview['review'] = $request['review'] ?? abort(400, 'missing required element');
        $library = new \Models\Library();
        $isPossessed = $library->find($request['bookId']);
        if (!empty($isPossessed)) {
            $comment = new Comment();
            $comment->save($newReview);
        } else {
            abort(400, "non authorised action");
        }
    }

    public function updateReview($id, $request)
    {
        $review = new Comment();
        $newReview = $review->find($request['reviewId']);
        $newReview['user_id'] !== $id ?? abort(400, "non authorised action");
        $newReview['review'] = $request['review'] ?? $newReview['review'];
        $newReview['comment'] = $request['comment'] ?? $newReview['comment'];
        $this->save($newReview);
        echo jsonResponse($newReview);
    }

    public function profile($id)
    {
        $user = $this->find($id);
        $library = new Library();
        $user['possessedBooks'] = $library->selectCount('book_version_id', ['user_id', '=', $id]);
        $user['finishedBooks'] = $library->selectCount('book_version_id', ['user_id', '=', $id], ['reading_state_id', '=', 3]);
        $user['inReadingBooks'] = $library->selectCount('book_version_id', ['user_id', '=', $id], ['reading_state_id', '=', 2]);
        $customQuery = $this->customQuery(
            "SELECT COUNT(book_version_id) 
                    FROM libraries 
                    WHERE added_at 
                    BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() 
                    AND user_id = $id 
                    AND reading_state_id = 2");
        $user['inReadingBooksLastMonth'] = $customQuery->fetchColumn();
        echo jsonResponse($user);
    }
}