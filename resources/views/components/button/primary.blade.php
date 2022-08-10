{{--
-- Important note:
--
-- This template is based on an example from Tailwind UI, and is used here with permission from Tailwind Labs
-- for educational purposes only. Please do not use this template in your own projects without purchasing a
-- Tailwind UI license, or they’ll have to tighten up the licensing and you’ll ruin the fun for everyone.
--
-- Purchase here: https://tailwindui.com/
--}}

<x-button {{ $attributes->merge(['class' => 'text-white bg-green-600 hover:bg-green-600 active:bg-green-600 border-green-500']) }}>{{ $slot }}</x-button>
