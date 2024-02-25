<x-mail::message>
# Introduction

A new Story was added with {{ $title }}

<x-mail::button :url="'/dashboard'">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
