@extends('backend.layouts.app')


@section('content')
<!-- Add rows table -->
<section id="add-row">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">


                </div>
                <div class="card-content">
                    <div class="card-body">

                        <a href="{{   route('admin.property.create')   }}"  class="btn btn-primary mb-2"><i
                                class="feather icon-plus"></i>&nbsp;
                            {{ trans('backend.new') }}
                        </a>
                        <div class="table-responsive">
                            <table class="table add-rows">
                                <thead>
                                    <tr>
                                        <th>S. NO</th>


                                        <th>{{ trans('backend.image') }}</th>
                                        <th>{{ trans('backend.owner') }}</th>
                                        <th>{{ trans('backend.price') }}</th>
                                        <th>{{ trans('backend.area_size') }}</th>
                                        <th>{{ trans('backend.location') }}</th>
                                        <th>{{ trans('backend.property_type') }}</th>
                                        <th>{{ trans('backend.listing_type') }}</th>
                                        <th>{{ trans('backend.rooms_type') }}</th>
                                        <th>{{ trans('backend.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($properties as $property)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>


                                        <td align="center"> <img style="height: 50px;width: 50px;" class="img-circle"
                                                src="{{  URL::to('uploads/properties/')}}/{{ $property->f_image }}"></td>

<td>{{ $property->user->full_name}}</td>
<td>{{ $property->price }}</td>
<td>{{ $property->area_size }}</td>
<td>{{ $property->location }}</td>




                                        <td>
                                            @foreach ($property->property_types as $propertyt)
                                          {{ $propertyt->name  }}
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($property->listing_types as $propertyl)
                                            {{ $propertyl->name  }}
                                            @endforeach
                                        </td>

<td>
                                            @foreach ($property->rooms_types as $propertyr)
                                            {{ $propertyr->name  }}
                                            @endforeach
                                        </td>


                                        <td>
                                            <a href="{{   route('admin.property.edit',$property->id) }}"> <i
                                                    class="feather icon-edit font-medium-5"></i> EDIT</a>
                                           | <a href=""
                                                onclick="if(confirm('Are You sure you want to delete this')){event.preventDefault();document.getElementById('delete-form-{{ $property->id }}').submit();}else{event.preventDefault();}">
                                                <i class="feather icon-trash  font-medium-5"> </i>DELETE</a>
                                            <form id="delete-form-{{ $property->id }}" method="post"
                                                action="{{ route('admin.property.destroy',$property->id) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>

                                        </td>
                                    </tr>
                                    @endforeach


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>S. NO</th>

    <th>{{ trans('backend.image') }}</th>
    <th>{{ trans('backend.owner') }}</th>
    <th>{{ trans('backend.price') }}</th>
    <th>{{ trans('backend.area_size') }}</th>
    <th>{{ trans('backend.location') }}</th>
    <th>{{ trans('backend.property_type') }}</th>
    <th>{{ trans('backend.listing_type') }}</th>
    <th>{{ trans('backend.rooms_type') }}</th>
    <th>{{ trans('backend.action') }}</th>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ Add rows table -->



@endsection
