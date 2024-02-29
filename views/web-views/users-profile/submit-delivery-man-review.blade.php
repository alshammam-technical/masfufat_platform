@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('submit_a_review'))

@section('content')

<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-4 mt-2 rtl"
     style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
    <div class="row">
        <!-- Sidebar-->
        <section class="col-lg-12  col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 style="margin-left: 20px;">{{\App\CPU\Helpers::translate('Submit_a_Deliveryman_Review')}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('submit-deliveryman-review')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">{{\App\CPU\Helpers::translate('rating')}}</label>
                                <select class="form-control" name="rating">
                                    <option value="1">{{\App\CPU\Helpers::translate('1')}}</option>
                                    <option value="2">{{\App\CPU\Helpers::translate('2')}}</option>
                                    <option value="3">{{\App\CPU\Helpers::translate('3')}}</option>
                                    <option value="4">{{\App\CPU\Helpers::translate('4')}}</option>
                                    <option value="5">{{\App\CPU\Helpers::translate('5')}}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">{{\App\CPU\Helpers::translate('comment')}}</label>
                                <input name="order_id" value="{{$order->id}}" hidden>
                                <textarea class="form-control" name="comment"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <a href="{{ URL::previous() }}" class="btn btn-secondary">{{\App\CPU\Helpers::translate('back')}}</a>

                            <button type="submit" class="btn bg-primaryColor text-light">{{\App\CPU\Helpers::translate('submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

</div>
@endsection

@push('script')
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
                dropFileLabel: "{{\App\CPU\Helpers::translate('drop_here')}}",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{\App\CPU\Helpers::translate('input_png_or_jpg')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{\App\CPU\Helpers::translate('file_size_too_big')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
@endpush
