@extends('layouts.app')
@section('content')

<div class="container py-5">

    <h1 class="mb-5">
        //this is: {{ $project['title'] }}
    </h1>
    <div class="card p-3">
        <div class="card-body">
            {{-- <h5 class="card-title">Title: {{ $project['title'] }}</h5> --}}
            <h6 class="card-subtitle mb-2 text-body-secondary">Category: <span class="badge bg-dark">{{ $project->type ? $project->type->type : '-'  }}</span></h6>
            <ul class="ps-0 d-flex gap-1"><span class="card-subtitle text-body-secondary">Tech stack: </span> 
                @forelse ($project->technologies()->orderBy('technology', 'asc')->get() as $tech)
                    <li class="badge text-bg-info">
                        {{ $tech->technology }}
                    </li>
                @empty
                    -
                @endforelse
            </ul>
            <p class="card-text">{{ $project['description'] }}</p>
            <div class="link-wrapper mb-3">
                <a href="{{ $project['website_link'] }}" target="_blank" class="card-link">to website</a>
                <a href="{{ $project['source_code_link'] }}" target="_blank" class="card-link">to source</a>
            </div>
            <div class="client-wrapper mb-5">
                <span class="card-subtitle me-3 text-body-secondary">Client: {{ $project['client'] }}</span>
                <span class="card-subtitle text-body-secondary">Client Category: {{ $project['client_category'] }}</span>
            </div>
            <a href="{{ route('projects.index') }}" class="btn btn-warning">Back to project list</a>
        </div>
    </div>

</div>

@endsection