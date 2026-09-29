@extends('layouts.auth')

@section('content')
    <div class="flex flex-col gap-3">
        <div class="flex justify-between items-center">
            <div class="text-[24px]">
                Calendar
            </div>
        </div>
        <x-container theme="white">
            <table class="w-full table-fixed border-collapse text-left text-[15px]">
                <thead>
                    <tr class="border-b border-current/10">
                        <th class="w-16 font-normal opacity-60 whitespace-nowrap"></th>
                        <th class="font-normal text-center opacity-60 whitespace-nowrap">Monday 28</th>
                        <th class="font-normal text-center opacity-60 whitespace-nowrap">Tuesday 29</th>
                        <th class="font-normal text-center opacity-60 whitespace-nowrap">Wednesday 30</th>
                        <th class="font-normal text-center opacity-60 whitespace-nowrap">Thursday 1</th>
                        <th class="font-normal text-center opacity-60 whitespace-nowrap">Friday 2</th>
                        <th class="font-normal text-center opacity-60 whitespace-nowrap">Saturday 3</th>
                    </tr>
                </thead>
                @php
                    $y = 'bg-amber-200';
                    $r = 'bg-red-700 text-white';
                    $g = 'bg-green-700 text-white';
                    $e = 'bg-gray-400';
                    $slots = [
                        10 => [1 => ['Lesson 08', $y], 2 => ['Lesson 10', $y], 3 => ['Lesson 27', $r], 5 => ['Lesson 12', $y]],
                        11 => [5 => ['Lesson 13', $y]],
                        12 => [0 => ['Lesson 07', $y], 1 => ['Lesson 09', $y], 2 => ['Lesson 11', $y], 3 => ['Lesson 28', $r], 4 => ['Lesson 03', $g]],
                        17 => [0 => ['EM 1', $e], 1 => ['EM 2', $e], 2 => ['EM 3', $e], 3 => ['EM 4', $e], 4 => ['AV EM', $e]],
                        18 => [0 => ['Lesson 21', $y], 1 => ['Lesson 23', $y], 2 => ['Lesson 25', $r], 3 => ['Lesson 01', $g], 4 => ['Lesson 04', $g]],
                        19 => [0 => ['Lesson 22', $y], 1 => ['Lesson 24', $r], 2 => ['Lesson 26', $r], 3 => ['Lesson 02', $g], 4 => ['Lesson 05', $g]],
                    ];
                @endphp
                <tbody>
                    @for ($i = 9; $i < 20; $i++)
                        <tr class="border-b border-current/10 last:border-0">
                            <td class="px-3 py-3 whitespace-nowrap">{{ $i }}H</td>
                            @for ($d = 0; $d < 6; $d++)
                                @php($cell = $slots[$i][$d] ?? null)
                                <td @class(['px-3 py-5 whitespace-nowrap text-center border-current/10', 'border-r' => $d < 5, $cell[1] ?? null])>{{ $cell[0] ?? '' }}</td>
                            @endfor
                        </tr>
                    @endfor
                </tbody>
            </table>
        </x-container>


    </div>
@endsection
