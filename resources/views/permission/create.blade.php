<x-app-layout>

    <x-slot name="header">
        Create Permission
    </x-slot>

    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <x-alertBox />

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Permission</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('permissions.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('permission.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
