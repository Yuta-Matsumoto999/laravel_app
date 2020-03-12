@extends ('layouts.app')
@section ('content')
<h1 class="page-header">ToDo一覧</h1>
<p class="text-right">
  <a class="btn btn-success" href="/todo/create">ToDoを追加</a>
</p>
<table class="table">
  <thead class="thead-light">
    <tr>
      <th>ID</th>
      <th>やること</th>
      <th>作成日時</th>
      <th>更新日時</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="align-middle">1</td>
      <td class="align-middle">静的なTodoです</td>
      <td class="align-middle">2017/01/01</td>
      <td class="align-middle">2017/01/10</td>
      <td><a class="btn btn-primary" href="">編集</a></td>
      <td><button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button></td>
    </tr>
  </tbody>
  @foreach ($todos as $todo) <!-- $todosはcompactで入ってきた配列　$todoはcollectionインスタンス -->
    <tr>
      <td class="align-middle">{{ $todo->id }}</td>
      <td class="align-middle">{{ $todo->title }}</td>
      <td class="align-middle">{{ $todo->created_at }}</td>　　　　　　　　　　<!-- collectionインスタンスからvalueを１つずつ取得して出力 -->
      <td class="align-middle">{{ $todo->updated_at }}</td>　　　　　　　　　　
      <td><a class="btn btn-primary" href="{{ route('todo.edit', $todo->id) }}">編集</a></td>　<!-- url間でのidの受け渡し　DBとの通信は行われていない -->
      <td>
        {!! Form::open(['route' => ['todo.destroy', $todo->id], 'method' => 'DELETE']) !!}
          {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
      </td>
    </tr>
  @endforeach
</table>
@endsection


