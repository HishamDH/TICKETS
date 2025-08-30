@props(['title', 'value'])

<div class="rounded-xl border border-orange-300 bg-white p-5 shadow-md hover:shadow-lg transition duration-300 ring-1 ring-orange-200 hover:ring-orange-400 flex flex-col justify-between">
    <div class="text-sm text-orange-600 font-semibold mb-2">{{ $title }}</div>
    <div class="text-lg text-slate-800 font-bold break-words">{{ $value }}</div>
</div>
