@extends('backend.layouts.app')
@section('content')


<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ trans('backend.properties') }}</h4>
                    @include('includes.partials.messages')
                </div>
                <div class="card-content">
                    <div class="card-body">



 <section id="statistics-card">
    <div class="row">
@foreach ($property->property_images as $property_images)
        <div id="{{ $property_images->id }}" class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">


                            <img width="200" height="100" class="user-photo"
                              src="{{ URL::to('uploads/properties',$property_images->property_image_path) }}" alt="">

<br>
                       <button class="deleteimage" data-id="{{ $property_images->id }}"
                        data-token="{{ csrf_token() }}">{{ trans('backend.delete') }}</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>





                        <script>
                            $(".deleteimage").click(function(){
                                var id = $(this).data("id");
                                var token = $(this).data("token");
                                $.ajax(
                                {
                                url: "<?php echo url('admin/property/image') ?>/"+id,
                                type: 'delete',
                                dataType: "JSON",
                                data: {
                                "id": id,
                                "_method": 'delete',
                                "_token": token,
                                },
                                success: function ()
                                {

                                console.log("it Work");
                                $('#'+id).hide();
                                }
                                });

                                });

                        </script>


        <form role="form" action="{{ route('admin.property.update',$property->id) }}" method="post"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}


            <div class="row">
                <div class="col-4">

                    <div class="card main-sectionx">
                        <div class="header">
                            <h2>{{ trans('backend.image') }}</h2>
                        </div>
                        <div class="body">
                            <input type="file" class="dropify" data-default-file="{{ URL::to('uploads/properties',$property->f_image) }}" data-allowed-file-extensions="png jpg jpeg"
                                name="f_image" >
                        </div>
                    </div>

                </div>
      <div class="col-8">

        <div class="card">
            <div class="header">
                <h2>{{ trans('backend.images') }}</h2>
            </div>
            <div class="body">
                <div class="file-loading">
                    <input id="file-1" type="file" name="property_images[]" multiple class="file" data-overwrite-initial="false"
                        data-min-file-count="0">
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $("#file-1").fileinput({
                rtl: true,
                showUpload: false,
                theme: 'fa',
                uploadUrl: "/image-view",
                uploadExtraData: function() {
                    return {
                        _token: $("input[name='_token']").val(),
                    };
                },
                allowedFileExtensions: ['jpg', 'png', 'jpeg'],
                overwriteInitial: false,
                maxFilesNum: 20,
                slugCallback: function (filename) {
                    return filename.replace('(', '_').replace(']', '_');
                }
            });
        </script>



    </div>
            </div>









         <div class="row">
            <div class="col-sm-12">
                <div class="card overflow-hidden">
                    <div class="card-content">
                        <div class="card-body">

                            <!-- Tab panes -->

                                <div class="tab-pane active" id="home-property" role="tabpanel"
                                    aria-labelledby="home-tab-justified">
                                    <h4 class="card-title">
                                        {{ trans('backend.price') }}</h4>

                                    <input type="text" class="form-control" name="price" value="{{ $property->price }}"
                                        aria-required="true">
                               </div>
                                <div class="tab-pane" id="profile-property" role="tabpanel" aria-labelledby="profile-tab-justified">
                                    <h4 class="card-title">
                                        {{ trans('backend.area_size') }}</h4>

                                    <input type="text" class="form-control" name="area_size" value="{{   $property->area_size }}"
                                        aria-required="true">

                                </div>
                                <div class="tab-pane" id="messages-property" role="tabpanel"
                                    aria-labelledby="messages-tab-justified">
                                    <h4 class="card-title">
                                        {{ trans('backend.location') }}</h4>

                                    <input type="text" class="form-control" name="location" value="{{   $property->location }}"
                                        aria-required="true">

                                </div>
<div class="tab-pane" id="messages-property" role="tabpanel" aria-labelledby="messages-tab-justified">
    <h4 class="card-title">
        {{ trans('backend.description') }}</h4>

   <textarea type="text" class="form-control" name="description">{!! $property->description !!}</textarea>
</div>



                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="row clealfix">



                <div class="col-sm-4">
                            <div class="card">
                                <div class="header">
                                    <h2>{{ trans('backend.listing_type') }}</h2>
                                </div>
                                <div class="body">

                                    <select id="single-selection" name="listing_type">


                                        @foreach ($listing_types as $listing_type)
                                        <option value="{{ $listing_type->id }}" @foreach ($property->listing_types as $propertyl)
                                            @if ($propertyl->id == $listing_type->id)
                                            selected
                                            @endif
                                            @endforeach
                                            > {{ $listing_type->name }} </option>
                                        @endforeach


                                    </select>



                                </div>
                            </div>
                        </div>


                <div class="col-sm-4">
                    <div class="card">
                        <div class="header">
                            <h2>{{ trans('backend.rooms_type') }}</h2>
                        </div>
                        <div class="body">

<select id="single-selection" name="rooms_type">


    @foreach ($rooms_types as $rooms_type)
    <option value="{{ $rooms_type->id }}" @foreach ($property->rooms_types as $propertyr)
        @if ($propertyr->id == $rooms_type->id)
        selected
        @endif
        @endforeach
        > {{ $rooms_type->name }} </option>
    @endforeach


    </select>



                        </div>
                    </div>
                </div>











                <div class="col-sm-4">
                    <div class="card">
                        <div class="header">
                            <h2>{{ trans('backend.property_type') }}</h2>
                        </div>
                        <div class="body">
                            <div class="multiselect_div">
                                <select id="single-selection" name="property_type">
                              @foreach ($property_types as $property_type)
                                <option value="{{ $property_type->id }}"
                                    @foreach ($property->property_types as $propertyt)
                                    @if ($propertyt->id == $property_type->id)
                                    selected
                                    @endif
                                    @endforeach
                                    > {{ $property_type->name }} </option>
                                @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                </div>




            </div>





            <div class="box-footer">
                <button type="submit" class="btn btn-primary">{{ trans('backend.save') }}</button>
                <a type="button" class="btn btn-warning"
                    href="{{   route('admin.property.index')   }}">{{ trans('backend.back') }}</a>
            </div>
</form>


</div>
</div>
</div>
</div>
</div>
</section>


@endsection
