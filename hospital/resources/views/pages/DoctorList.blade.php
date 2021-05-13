@extends('layouts.app')

@section('content')

<div class="container content col-md-12">
  <div class="row">
      <div class="col-sm">
        <p style="font-weight: 700 !important;">our doctors</p>
          <form class="black_text" method="post" action="{{ route('DoctorList') }}">
            @csrf
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">name</th>
                  <th scope="col">surname</th>
                  <th scope="col">occupation</th>
                  <th scope="col">Email</th>
                  <th scope="col">select</th>
                </tr>
              <thead>
                <tbody>
                    <?php  $i=0;  ?>
                    @foreach ($doctors as $doctor)

                      <tr>
                      <td> {{$doctor->name}} </td>
                      <td>{{$doctor->surname}} </td>
                      <td>{{$doctor->occupation}}</td>
                      <td> {{$doctor->email}}</td>
                      <td> <!--input onchange='this.form.submit();' type='radio' id={{--$doctor->id--}} name='drone' value={{--$doctor->id--}}-->
                          <input type="hidden" name="arrnum" value=<?php  echo $i;  ?> />
                          <button class='btn btn-dark' type='submit' name='drone' value={{$doctor->id}}>pick</button>
                      </td>
                      </tr>
                      <?php  $i++;  ?>
                    @endforeach


                </tbody>
            </table>
          </form>
      </div>
      <div class="col-sm">
      <p style="font-weight: 700 !important;">Work calendar</p>
      @include('includes.DoctorCalendar')

      </div>
  </div>
</div>


@endsection
