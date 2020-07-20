@extends('cp.reports.reportIndex')
@section('shopsReport')

    <div class="box-header">
        <h3 class="box-title"><b> المتاجر</b> &nbsp;&nbsp;( {{sizeof($users)}} )&nbsp;&nbsp;</h3>

        <div style="padding-left: 500px" class="btn btn-default">
            @if(sizeof($users) > 0)
                    <a href="{{route('shopsInvoice')}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> طباعة </a>
            @endif
        </div>
        <span class="pull-left" style="padding-left: 100px">
            <img src="{{asset("default.png")}}" style="width:80px; height:60px">
        </span>
    </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered table-hover">

@if(sizeof($users) > 0)
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> الاسم </th>
                                    <th scope="col"> الصورة </th>
                                    <th scope="col">الموبايل </th>
                                    <th scope="col"> البريد الالكتروني</th>
                                    <th scope="col"> website </th>
                                    <th scope="col"> السجل التجاري </th>
                                    <th scope="col"> الرقم الضريبي </th>
                                    <th scope="col"> المواعيد  </th>
                                    <th scope="col"> القسم التابع له  </th>
                                    <th scope="col"> الحالة </th>
                                </tr>
                                </thead>
                                <tbody id="myTable">
                                @foreach($users as $c)
                                    <tr id="main_cat_{{$c->id}}" onclick="myFunction({{$c->id}})" class="{{$c->suspend == 1 ? 'table-danger' :''}}">
                                        <td>{{$c->id}}</td>
                                        <td>{{$c->name}}</td>
                                        @if($c->image != NULL)
                                            <th><img src="{{$c->image}}"  width="40px" height="40px"></th>
                                        @else
                                            <th> - </th>
                                        @endif
                                        <td>{{$c->phone}}</td>
                                        <td>{{$c->email}}</td>
                                        <td>{{$c->website}}</td>
                                        <td>{{$c->business_id}}</td>
                                        <td>{{$c->tax_num}}</td>
                                        <td>{{$c->open_hours}} <br> [ {{$c->open_from}} - <br> {{$c->open_to}} ]</td>
                                        <td>{{$c->cat_name_ar}} / <br> {{$c->cat_name_en}}</td>

                                        <td>
                                            @if($c->active == 1)
                                                <i class="font-success show icon-check"></i>
                                            @else
                                                <i class="font-danger show icon-close"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
 @else
                <thead>

                <tr>
                    <b>عذرا لا توجد بيانات</b>
                </tr>
                </thead>
@endif
                            </table>
                        </div>
                        <!-- /.box-body -->



@endsection
