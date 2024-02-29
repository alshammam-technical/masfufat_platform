@extends('layouts.front-end.app')

@section('title',Helpers::translate('submit_a_review'))

@section('content')

<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-4 mt-2 rtl"
     style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
    <div class="row">
        <section class="col-lg-12  col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="__ml-20">{{Helpers::translate('submit_a_review')}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('review.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">{{Helpers::translate('rating')}}</label>
                                <select class="form-control" name="rating">
                                    <option value="1">{{Helpers::translate('1')}}</option>
                                    <option value="2">{{Helpers::translate('2')}}</option>
                                    <option value="3">{{Helpers::translate('3')}}</option>
                                    <option value="4">{{Helpers::translate('4')}}</option>
                                    <option value="5">{{Helpers::translate('5')}}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">{{Helpers::translate('comment')}}</label>
                                <input name="product_id" value="{{$order_details->product_id}}" hidden>
                                <input name="order_id" value="{{$order_details->order_id}}" hidden>
                                <textarea class="form-control" name="comment"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">{{Helpers::translate('attachment')}}</label>
                                <div class="row coba"></div>
                                <div class="mt-1 text-info">{{Helpers::translate('File type: jpg, jpeg, png. Maximum size: 2MB')}}</div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <a href="{{ URL::previous() }}" class="btn btn-secondary">{{Helpers::translate('back')}}</a>

                            <button type="submit" class="btn bg-primaryColor">{{Helpers::translate('submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

</div>
@endsection

@push('script')
    <script src="{{asset('public/assets/front-end')}}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('public/assets/front-end/js/spartan-multi-image-picker.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $(".coba").spartanMultiImagePicker({
                fieldName: 'fileUpload[]',
                maxCount: 5,
                rowHeight: '150px',
                groupClassName: 'col-md-4',
                placeholderImage: {
                    image: '{{asset('public/assets/front-end/img/image-place-holder.png')}}',
                    width: '100%'
                },
                dropFileLabel: "{{Helpers::translate('drop_here')}}",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{Helpers::translate('input_png_or_jpg')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{Helpers::translate('file_size_too_big')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
@endpush
