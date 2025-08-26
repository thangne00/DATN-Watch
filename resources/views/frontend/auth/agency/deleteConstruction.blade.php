@extends('frontend.homepage.layout')
@section('content')
<div class="profile-container pt20 pb20">
    <div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-medium">
            <div class="uk-width-large-1-5">
                @include('frontend.auth.agency.components.sidebar')
            </div>
           
                        </div>
                        <div class="text-right mb15">
                            <button class="btn btn-danger" type="submit" name="send" value="send">Xóa dữ liệu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
