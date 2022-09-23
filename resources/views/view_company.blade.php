@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-head"><h2 class="text-center p-2">{{ $company->name }}</h2></div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ $company->image_url }}" height="100px" width="100px" alt="https://static.thenounproject.com/png/194055-200.png">
                    </div>
                    <p>{{ $company->description }}</p>
                    <p style="float: right;">Created by {{ $company->created_by_user->name }}</p>
                    <i id="like_button" style="float: left;"> {{ $company->likes_amount }} likes</i>
                    <input type="hidden" id="company_id" value="{{ $company->id }}">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
