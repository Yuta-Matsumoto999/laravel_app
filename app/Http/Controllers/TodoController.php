<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo; 
use Auth;

class TodoController extends Controller
{
    private $todo;

    public function __construct(Todo $instanceClass)
    {
        $this->middleware('auth');  
        $this->todo = $instanceClass;
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->todo->all(); //Todoインスタンスからallでレコードを１つずつ全て取得しcollectionインスタンスとして $todos に格納
        $todos = $this->todo->getByUserId(Auth::id());
        return view('todo.index', compact('todos')); //compactメソッド　= 引数をkey（変数名）　valueが変数の中身　の連想配列を作る = [todos => $todos]
    }                                                //viewの返り値はviewインスタンス
                                                    //第一引数は表示させたいファイル　第二引数は渡すデータ
                                                    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)     //作成ボタンが押されたらルーティングでこのメソッドが選別される
    {
        $input = $request->all();              //requestインスタンスをallで1つずつ全てとる　$inputに連想配列として格納　requestインスタンスから keyにinputタグのname　valueにinputタグのvalue
        $input['user_id'] = Auth::id();
        $this->todo->fill($input)->save();      //fill($input)でTodoインスタンスに格納する値を選別する　fillの返り値は title => value が格納されたTodoインスタンス
        return redirect()->to('todo');          //$inputにはトークンとtitleがkeyとして格納されている　$fillableの指定によりtitle以外は除外される
        //                                      //$inputのtitleのvalueが追加されたTodoインスタンスがfillの返り値になり、それをsaveでDBに格納
    }                                           //saveが返すのは真偽値
                                                //redierct処理　toの引数は相対パス todoとしてルーティングされ、indexメソッドが動き、最終的に一覧画面に遷移する
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)                   //編集ボタンを押すとルーティングによりeditメソッドが作動する
    {
        $todo = $this->todo->find($id);       //find($id)で$idが該当するレコードのTodoインスタンスを１つ取得
        return view('todo.edit', compact('todo')); //compactメソッド　= 引数をkey（変数名）　valueが変数の中身　の連想配列を作る = [todos => $todos]
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)   //更新ボタンが押されるとルーティングでupdateメソッドが走る
    {
        $input = $request->all();                       //requestインスタンスをallで１つずつ全てとる　$inputに連想配列として格納　requestインスタンスから keyにinputタグのname　valueにinputタグのvalue
        $this->todo->find($id);
        $this->todo->fill($input);
        $this->todo->save(); //find($id)で$idが該当するレコードのTodoインスタンスを１つ取得 そのTodoインスタンスにfill($input)で精査したtitleのvalueが入る　そのTodoインスタンスをsaveでDBに格納
        return redirect()->to('todo');                  //redierct処理　toの引数は相対パス todoとしてルーティングされ、indexメソッドが動き、最終的に一覧画面に遷移する
    }
        //

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)                //削除ボタンを押すとルーティングによりdestroyメソッドが走る
    {
        $this->todo->find($id)->delete();       //find($id)でidが該当するレコードのTodoインスタンスを１つ取得　それをdeleteでDBから削除　物理削除　deleteが返すのは真偽値
        return redirect()->to('todo');          //redierct処理　toの引数は相対パス todoとしてルーティングされ、indexメソッドが動き、最終的に一覧画面に遷移する
        //
    }
}
