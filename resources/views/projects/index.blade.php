@extends('layouts.app')
@section('content')

<div class="container">

    <div class="title-wrapper py-5">
        <h1 class="mb-3">
            //my-proj-portfolio
        </h1>

        @if(request()->session()->exists('message'))
            <div class="text-danger py-3">
                {{ request()->session()->pull('message') }}
            </div>
        @endif

        @if (request('trashed')) 
        {{-- le request('key') permette di recuperare la richiesta corrente della pagina --}}
        {{-- usiamo poi l'if per scomporre la navbar a seconda della pagina richiamata --}}
        <span>
            Number of trashed el: {{ $num_trashed }}
        </span>
        <a href="{{ route('projects.index') }}" class="btn btn-warning">
            Go back to list
        </a>
        @else
        <a href="{{ route('projects.create') }}" class="w-auto btn btn-primary">
            + add new project
        </a>
        <a href="{{ route('projects.index', ['trashed' => true]) }}" class="w-auto btn btn-secondary">
            {{-- [ dentro le quadre passiamo il params, fatto da key => value ] --}}
            open bin
        </a>
        @endif
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">title</th>
                <th scope="col">proj type</th>
                <th scope="col">tech</th>
                <th scope="col">client</th>
                <th scope="col">created</th>
                <th scope="col">actions</th>
            </tr>
        </thead>
    
        <tbody>
    
            @foreach ($projects as $key=>$project)

            <tr>
                <td>{{ $project->id }}</td>
                <td><a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a></td>
                <td>{{ $project->type ? $project->type->type : '-'  }}</td>
                <td>
                    <ul class="d-flex gap-1">
                        @forelse ($project->technologies()->orderBy('technology', 'asc')->get() as $tech)
                            <li class="badge text-bg-info">
                                {{ $tech->technology }}
                            </li>
                        @empty
                            -
                        @endforelse
                    </ul>
                </td>
                <td>{{ $project->client }}</td>
                <td>{{ $project->created_at->format('Y-m-d') }}</td>
                <td>
                    <div class="actions-wrapper d-flex gap-3">
                        <a href="{{ route('projects.edit', $project->slug) }}" class="btn btn-sm btn-warning">&Theta;</a>
                        <a href="{{ route('projects.delete', $project->id) }}" class="btn btn-sm btn-danger">&cross;</a>
                        @if($project->trashed())
                        <form 
                            action="{{ route('projects.restore', $project) }}" method="POST"
                            class="row g-3">
                                @csrf                            
                                <input type="submit" value="r" class="btn btn-secondary">
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
                
            @endforeach
    
        </tbody>
        
    </table>

</div>


@endsection