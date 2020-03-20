@extends('backend.layouts.app')
@section('content')


<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ trans('backend.rooms_type') }}</h4>
                    @include('includes.partials.messages')
                </div>
                <div class="card-content">
                    <div class="card-body">


        <form role="form" action="{{ route('admin.rooms_type.update',$rooms_type->id) }}" method="post"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}


            <div class="row clealfix">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="header">
                            <h2>{{ trans('backend.name') }}  </h2>
                        </div>
                        <div class="body">

                            <input
                                value="@if (old('name')){{ old('name') }}@else{{ $rooms_type->name }}@endif"
                                type="text" class="form-control" id="name" name="name">

                        </div>
                    </div>
                </div>




            </div>






            <div class="box-footer">
                <button type="submit" class="btn btn-primary">{{ trans('backend.save') }}</button>
                <a type="button" class="btn btn-warning"
                    href="{{   route('admin.rooms_type.index')   }}">{{ trans('backend.back') }}</a>
            </div>
</form>


</div>
</div>
</div>
</div>
</div>
</section>


@endsection
