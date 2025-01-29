<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\BookCategory;
use App\Models\BookHistory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function booksView(Request $request){
        $userId = Auth::id();
        $from = $request->has('from') ? $request->input('from') : '';
        $categoryID = $request->has('category') ? $request->input('category') : '';
        $authorID = $request->has('author') ? $request->input('author') : '';
        $borrowedBy = $request->has('borrowedBy') ? $request->input('borrowedBy') : '';

        $booksData = DB::table('books')
                        ->join('books_category as cat','cat.id','=','books.CategoryID')
                        ->join('book_authors as ath','ath.id','=','books.AuthorID')
                        ->leftJoin('users','users.id','=','books.BorrowedID')
                        ->select('books.id','books.book_name','cat.book_category_name',
                                'ath.author_name','users.name');
            if($from == 'filter'){
                if(!empty($categoryID)){
                    $booksData->where('books.CategoryID',$categoryID);
                }
                if(!empty($authorID)){
                    $booksData->where('books.AuthorID',$authorID);
                }
                if(!empty($borrowedBy)){
                    $booksData->where('books.BorrowedID',$borrowedBy);
                }
            }
        $booksData = $booksData->paginate(2);

        $bookCategoryData = BookCategory::where('AddByID',$userId)->get();
        $authorData = Author::where('AddByID',$userId)->get();
        $userData = User::where('role','!=','admin')->get();
        
        return view('booksView',compact('booksData','bookCategoryData','authorData','categoryID','authorID','userData','borrowedBy'));
    }

    public function addBookView(){
        $userId = Auth::id();

        $bookCategoryData = BookCategory::where('AddByID',$userId)->get();
        $authorData = Author::where('AddByID',$userId)->get();

        return view('addBookView',compact('bookCategoryData','authorData'));
    }

    public function saveCategory(Request $request){
        $categoryName = trim($request->input('categoryName'));
        $userId = Auth::id();

        $existCategory = BookCategory::where('AddByID',$userId)
                        ->where('book_category_name',$categoryName)
                        ->first();
        if(empty($existCategory)){
            $bookCategory = new BookCategory();
            $bookCategory->book_category_name = $categoryName;
            $bookCategory->AddByID = $userId;
            $bookCategory->save();
    
            $bookCategoryData = BookCategory::where('AddByID',$userId)->get();
            return response()->json([
                'bookCategoryData' => $bookCategoryData,
                'status' => 'true',
            ]);
        }else{
            return response()->json([
                'status' => 'false',
            ]);
        }
    }

    public function categoryList(){
        $userId = Auth::id();
        $bookCategoryData = BookCategory::where('AddByID',$userId)->get();

        return view('categoryList',compact('bookCategoryData'));
    }

    public function deleteCategory(Request $request){
        $id = $request->input('id');
        $category = BookCategory::where('id',$id)->first();
        if(!empty($category)){
            $category->delete();
            return redirect()->route('categoryList')->with('message','Category Deleted');
        }else{
            return redirect()->route('categoryList')->with('message','Category Not Found');
        }
        
    }

    public function getCategoryData(Request $request){
        $categoryID = $request->input('categoryId');
        $bookCategoryData = BookCategory::where('id',$categoryID)->first();
        return response()->json([
            'bookCategoryData'=>$bookCategoryData,
        ]);
    }

    public function editCategorySave(Request $request){
        $categoryID  = $request->input('categoryIDEdit');
        $categoryName = $request->input('bookCategoryEdit');

        $category = BookCategory::where('book_category_name',$categoryName)
                                    ->where('id','!=',$categoryID)
                                    ->first();
        if(empty($category)){
            BookCategory::where('id',$categoryID)->update([
                'book_category_name' => $categoryName,
            ]);
            return redirect()->route('categoryList')->with('message','Category Updated');
        }else{
            return redirect()->route('categoryList')->with('message','Category Name Alredy Taken.');
        }
    }

    public function authorList(){
        $userId = Auth::id();
        $authorData = Author::where('AddByID',$userId)->get();
        return view('authorList',compact('authorData'));
    }

    public function addAuthorSave(Request $request){
        $authorName = trim($request->input('bookAuthor'));
        $userId = Auth::id();

        $author = new Author();
        $author->author_name = $authorName;
        $author->AddByID = $userId;
        $author->save();
        return redirect()->route('authorList')->with('message','Author Added Succesfully');
    }

    public function getAuthorDetails(Request $request){
        $authorId = $request->input('authorId');
        $userId = Auth::id();
        $authorData = Author::where('id',$authorId)
                                // ->where('AddByID',$userId)
                                ->first();
        return response()->json([
            'authorData' => $authorData,
        ]);
    }

    public function editAuthorSave(Request $request){
        $authorName = trim($request->input('bookAuthorEdit'));
        $authorID   = $request->input('authorIDEdit');

        $author = Author::where('author_name',$authorName)
                            ->where('id','!=',$authorID)
                            ->first();
        if(empty($author)){
            Author::where('id',$authorID)
                    // ->where('AddByID',$userId)
                    ->update([
                        'author_name'=>$authorName,
                    ]);
            return redirect()->route('authorList')->with('message','Author Saved Successfully.');
        }else{
            return redirect()->route('authorList')->with('message','Author Alredy Exist.');
        }
    }

    public function bookSave(Request $request){
        $userId = Auth::id();

        $bookName = $request->input('bookName');
        $categoryID = $request->input('category');
        $authorID = $request->input('author');

        $books = new Book();
        $books->book_name = $bookName;
        $books->CategoryID = $categoryID;
        $books->AuthorID = $authorID;
        $books->AddByID = $userId;
        $books->save();

        return redirect()->route('booksView')->with('message','Book Added Succesfully');
    }

    public function deleteAuthor(Request $request){
        $authorID = $request->input('id');

        $author = Author::where('id',$authorID)->first();
        if(!empty($author)){
            $author->delete();
            return redirect()->route('authorList')->with('message','Author Deleted');
        }else{
            return redirect()->route('authorList')->with('message','Author Not Found');
        }
    }

    public function deleteBook(Request $request){
        $bookId = $request->input('id');

        $books = Book::where('id',$bookId)->first();
        if(!empty($books)){
            $books->delete();
            return redirect()->route('booksView')->with('message','Book Deleted');
        }else{
            return redirect()->route('booksView')->with('message','Book Not Found');
        }
    }

    public function editBookView(Request $request){
        $bookId = $request->input('id');
        $userId = Auth::id();

        $books = Book::where('id',$bookId)->first();

        if(!empty($books)){
            $bookCategoryData = BookCategory::where('AddByID',$userId)->get();
            $authorData = Author::where('AddByID',$userId)->get();

            return view('editBookView',compact('books','bookCategoryData','authorData'));
        }else{
            return redirect()->view('booksView')->with('message','Book Not Found.');
        }
    }

    public function editBookSave(Request $request){
     
        $bookName = $request->input('bookName');
        $categoryID = $request->input('category');
        $authorID = $request->input('author');
        $bookID   = $request->input('bookID');

        $books = Book::where('id',$bookID)->first();
        $books->book_name = $bookName;
        $books->CategoryID = $categoryID;
        $books->AuthorID = $authorID;
        $books->save();

        return redirect()->route('booksView')->with('message','Book Edited Succesfully');
    }

    public function bookHistoryView(){

        $bookHistory = DB::table('book_history as his')
                        ->join('users','users.id','=','his.BorrowedID')
                        ->paginate(15);


        return view('bookHistoryView',compact('bookHistory'));
    }
}
