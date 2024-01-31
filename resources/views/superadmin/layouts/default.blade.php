<x-main>
    <x-slot name="head">
        @include("superadmin.includes.head")
    </x-slot>

    @yield("content")

    <x-slot name="header">
        @include("superadmin.includes.header")
    </x-slot>

    <x-slot name="footer">
        @include("superadmin.includes.footer")
    </x-slot>

    <x-slot name="scripts">
        @yield("scripts")
    </x-slot>
</x-main>