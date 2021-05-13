@extends('layouts.app')

@section('content')
    <div class="container col-md-6">
        <h1 class="header " style="min-width: 503px;">Our Patient Database</h1>
        <div class="content">
            <table id="users" class="table content-2 table-striped table-hover">
                <thead>
                <tr>
                    <th >\</th>
                    <th >name</th>
                    <th >surname</th>
                    <th >Email</th>
                    <th >ID</th>
                </tr>
                <thead>
                <tbody>

                @foreach ($users as $user)

                    <tr>
                        <td><img src="/uploads/avatars/{{$user->avatar}}" style="width: 20px; height: 20px; float:left; border-radius:50%; margin-right: 0px"></td>
                        <td> {{$user->name}} </td>
                        <td>{{$user->surname}} </td>
                        <td> {{$user->email}}</td>
                        <td> {{$user->id}}</td>
                    </tr>

                @endforeach


                </tbody>
                <tfoot>
                <tr>
                    <th >name</th>
                    <th >surname</th>
                    <th >Email</th>
                    <th >ID</th>
                </tr>
                </tfoot>
            </table>
            @section('extra-script')
                {{Html::script('js/components/users.js')}}
            @endsection
        </div>
    </div>


@endsection
