@extends('cp.index')
@section('content')
    <div class="page-body" dir="rtl">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <div class="page-header-right">


                            <?php if(session()->has('insert_message')): ?>
                            <div class="alert alert-success dark alert-dismissible fade show col-lg-3" role="alert">
                                <i class="icon-thumb-up"></i>
                                <b>
                                    <?php echo e(session()->get('insert_message')); ?>
                                </b>
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close" >
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <?php endif; ?>

                            @if($errors->any())
                                <div class="alert alert-danger dark alert-dismissible fade show col-lg-3" role="alert">
                                    <i class="icon-thumb-down"></i>
                                    <b>
                                        @if ($errors)
                                            <?php echo "من فضلك اكمل ادخال البيانات المطلوبة !"; ?>
                                        @endif
                                    </b>
                                    <button class="close" type="button" data-dismiss="alert" aria-label="Close" data-original-title="" title="">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @endif


                            <h3>
                                <i data-feather="home"></i>
                                المتاجر
                            </h3>
                            {{--<ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}"><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item active">المتاجر</li>
                            </ol>--}}
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table" id="myTable">
                            <thead class="thead-dark">
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
                                <th scope="col">الاختيارات</th>
                            </tr>
                            </thead>
                            <tbody>
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
                                    <td>
                                        @if($c->suspend == 0)
                                            <a href="{{route('editClientStatus',$c->id)}}" >
                                                <button title="ايقاف " class="btn btn-danger">
                                                    -
                                                </button>
                                            </a>
                                        @else
                                            <a href="{{route('editClientStatus',$c->id)}}" >
                                                <button title="اعادة تشغيل " class="btn btn-success">
                                                    +
                                                </button>
                                            </a>
                                        @endif
                                    </td>


                                </tr>
                            @endforeach
                            {{--<tbody id="sub_cats_{{$category->id}}"></tbody>--}}
                            </tbody>
                        </table>
                    </div>{{--{{$users->links()}}--}}
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>




@endsection
