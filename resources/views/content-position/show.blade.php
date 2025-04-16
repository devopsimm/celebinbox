<x-app-layout>
    <x-slot name="header">
        {{ $contentPosition->name ?? 'Show Content Position' }}
    </x-slot>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Content Position</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('content-positions.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Key:</strong>
                            {{ $contentPosition->key }}
                        </div>
                        <div class="form-group">
                            <strong>Slots:</strong>
                            {{ $contentPosition->slots }}
                        </div>
                        <div class="form-group">
                            <strong>Posts:</strong>
                            {{ $contentPosition->posts }}
                        </div>
                        <div class="form-group">
                            <strong>Status:</strong>
                            {{ $contentPosition->status }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
