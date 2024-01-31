<x-main>
    <x-slot name="head">
        @include("contractor.admin.includes.head")
    </x-slot>

    @yield("content")

    <x-slot name="header">
        @include("contractor.admin.includes.header")
    </x-slot>

    <x-slot name="footer">
        @include("contractor.admin.includes.footer")
    </x-slot>

    <x-slot name="scripts">
        @yield("scripts")
    </x-slot>
</x-main>