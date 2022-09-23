@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-head"><h2 class="text-center p-2">Add new company</h2></div>
                <div class="card-body">
                    <form action="{{ route('save_company') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="company_name" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="company_description" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Image (URL)</label>
                            <input type="text" class="form-control" name="company_url">
                        </div>
                        <input type="hidden" name="creator" value="{{ Auth::user()->id }}">
                    
                        <br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
