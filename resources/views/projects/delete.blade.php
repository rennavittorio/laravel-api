@extends('layouts.app')
@section('content')


<div class="container">

    <h1 class="mb-5">
        Are you sure you want to delete this element?
        <span class="text-danger">
            {{ $project->title }}
        </span>
    </h1>
        
    <form 
    action="{{ route('projects.destroy', $project) }}" method="POST"
    class="row g-3">
        @csrf
        @method('DELETE')
    
        <div class="col-auto">
            <input type="submit" value="Delete" class="btn btn-danger"> 
        </div>

    </form>
    
    <div class="col-auto">
        <a href="{{ route('projects.index') }}" class="btn btn-warning">
            Go back to list
        </a>
    </div>

</div>

@endsection