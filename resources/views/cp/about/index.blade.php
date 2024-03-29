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
                                عن التطبيق
                            </h3>
                            {{--<ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}"><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item active">عن التطبيق</li>
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
                                {{--<th scope="col">#</th>--}}
                                <th scope="col">النص بالعربية</th>
                                <th scope="col">النص بالانجليزية</th>
                                <th scope="col">الاختيارات</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($abouts as $c)
                                    <tr id="main_cat_{{$c->id}}" onclick="myFunction({{$c->id}})">
                                        {{--<td>{{$c->id}}</td>--}}
                                        <td>
                                            <textarea class="form-control" name="body_ar" rows="15" placeholder="النص بالعربية">{{$c->body_ar}}</textarea>
                                        </td>
                                        <td>
                                            <textarea class="form-control" name="body_en" rows="15" placeholder="النص بالنجليزية" dir="ltr">{{$c->body_en}}</textarea>
                                        </td>
                                        <td>
                                            {{--@if(admin()->hasPermissionTo('Edit City'))--}}
                                            <button title="تعديل" type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit_{{$c->id}}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            {{--@endif--}}
                                        </td>

                                        <div class="modal fade" id="edit_{{$c->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">تعديل عن التطبيق</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form class="form-horizontal" method="post" action="{{route('editAbout')}}" enctype="multipart/form-data">
                                                        {{csrf_field()}}
                                                        <div class="modal-body">
                                                            <input type="hidden" name="term_id" value="{{$c->id}}">


                                                            <div class="form-group row {{ $errors->has('ar_name') ? ' has-error' : '' }}">
                                                                <label class="col-lg-12 control-label text-lg-right" for="textinput"> النص بالعربية</label>
                                                                <div class="col-lg-12">
                                                                    <textarea class="form-control" name="body_ar" rows="10" placeholder="النص بالعربية" required oninvalid="this.setCustomValidity('هذا الحقل مطلوب ادخاله')">{{$c->body_ar}}</textarea>
                                                                </div>
                                                            </div>
                                                            @include('cp.layouts.error', ['input' => 'ar_name'])

                                                            <div class="form-group row {{ $errors->has('en_name') ? ' has-error' : '' }}">
                                                                <label class="col-lg-12 control-label text-lg-right" for="textinput">النص بالنجليزية</label>
                                                                <div class="col-lg-12">
                                                                    <textarea class="form-control" name="body_en" rows="10" placeholder="النص بالنجليزية" required oninvalid="this.setCustomValidity('هذا الحقل مطلوب ادخاله')">{{$c->body_en}}</textarea>
                                                                </div>
                                                            </div>
                                                            @include('cp.layouts.error', ['input' => 'en_name'])






                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="reset" class="btn btn-dark" data-dismiss="modal">اغلاق</button>
                                                            <button class="btn btn-primary" type="submit">تعديل</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach
                            {{--<tbody id="sub_cats_{{$category->id}}"></tbody>--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->

    </div>


@endsection
